import { router } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import Form from './Form';

export default function Edit({ history, locales }) {
    const handleSubmit = (formData, setErrors) => {
        router.put(`/admin/company-histories/${history.id}`, formData, {
            onError: (errors) => {
                setErrors(errors);
            },
        });
    };

    return (
        <AppLayout>
            <div className="py-12">
                <div className="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 border-b border-gray-200">
                            <h2 className="text-2xl font-bold">Edit Company History - {history.year}</h2>
                        </div>

                        <div className="p-6">
                            <Form history={history} onSubmit={handleSubmit} processing={false} locales={locales} />
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
