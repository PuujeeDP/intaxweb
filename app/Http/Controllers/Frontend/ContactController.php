<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function index(): View
    {
        $captcha = $this->generateCaptcha();

        return view('frontend.contact.index', compact('captcha'));
    }

    /**
     * Generate a simple math captcha.
     */
    private function generateCaptcha(): array
    {
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        $answer = $num1 + $num2;

        Session::put('captcha_answer', $answer);

        return [
            'question' => "{$num1} + {$num2} = ?",
            'num1' => $num1,
            'num2' => $num2,
        ];
    }

    /**
     * Handle the contact form submission.
     */
    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'captcha' => 'required|numeric',
        ]);

        // Validate captcha
        $captchaAnswer = Session::get('captcha_answer');
        if ((int) $request->captcha !== $captchaAnswer) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['captcha' => __('frontend.captcha_invalid')]);
        }

        // Clear captcha from session
        Session::forget('captcha_answer');

        try {
            // Send email
            Mail::send([], [], function ($message) use ($validated) {
                $message->to(config('mail.from.address'))
                    ->replyTo($validated['email'], $validated['name'])
                    ->subject('Вэбээс мессеж: ' . $validated['subject'])
                    ->html($this->buildEmailHtml($validated));
            });

            return redirect()
                ->route('contact.index', ['locale' => app()->getLocale()])
                ->with('success', __('frontend.contact_success'));
        } catch (\Exception $e) {
            Log::error('Contact form email error: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('frontend.contact_error'));
        }
    }

    /**
     * Build HTML email content
     */
    private function buildEmailHtml(array $data): string
    {
        return "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                <h2 style='color: #059669; border-bottom: 2px solid #059669; padding-bottom: 10px;'>
                    Шинэ холбоо барих хүсэлт
                </h2>

                <div style='margin: 20px 0;'>
                    <p style='margin: 10px 0;'>
                        <strong>Нэр:</strong> {$data['name']}
                    </p>
                    <p style='margin: 10px 0;'>
                        <strong>И-мэйл:</strong>
                        <a href='mailto:{$data['email']}'>{$data['email']}</a>
                    </p>
                    " . ($data['phone'] ? "
                    <p style='margin: 10px 0;'>
                        <strong>Утас:</strong> {$data['phone']}
                    </p>
                    " : "") . "
                    <p style='margin: 10px 0;'>
                        <strong>Сэдэв:</strong> {$data['subject']}
                    </p>
                </div>

                <div style='background: #f3f4f6; padding: 15px; border-radius: 5px; margin: 20px 0;'>
                    <p style='margin: 0 0 5px 0;'><strong>Мессеж:</strong></p>
                    <p style='margin: 0; white-space: pre-wrap;'>" . nl2br(htmlspecialchars($data['message'])) . "</p>
                </div>

                <div style='margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; font-size: 12px;'>
                    <p>Энэ мессеж таны вэбсайтын холбоо барих хуудаснаас илгээгдсэн.</p>
                    <p>Огноо: " . now()->format('Y-m-d H:i:s') . "</p>
                </div>
            </div>
        ";
    }
}
