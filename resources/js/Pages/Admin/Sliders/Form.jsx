import AppLayout from '../../../Layouts/AppLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import TextInput from '../../../Components/TextInput';
import TextArea from '../../../Components/TextArea';
import LanguageTabs from '../../../Components/LanguageTabs';

export default function SliderForm({ slider, translations, locales }) {
    const isEditing = !!slider;
    const [uploading, setUploading] = useState(false);
    const [previewImage, setPreviewImage] = useState(slider?.image?.file_path || null);

    // Update preview image when slider prop changes
    useEffect(() => {
        setPreviewImage(slider?.image?.file_path || null);
    }, [slider?.image?.file_path]);

    const { data, setData, post: submit, put, processing, errors } = useForm({
        image_id: slider?.image_id || '',
        button_text: slider?.button_text || '',
        button_url: slider?.button_url || '',
        button_target: slider?.button_target || '_self',
        is_active: slider?.is_active ?? true,
        order: slider?.order || 0,
        translations: translations || {
            en: { title: '', subtitle: '', description: '' },
            mn: { title: '', subtitle: '', description: '' },
            zh: { title: '', subtitle: '', description: '' },
        },
    });

    const handleSubmit = (e) => {
        e.preventDefault();

        if (isEditing) {
            put(`/admin/sliders/${slider.id}`);
        } else {
            submit('/admin/sliders');
        }
    };

    const updateTranslation = (locale, field, value) => {
        setData('translations', {
            ...data.translations,
            [locale]: {
                ...data.translations[locale],
                [field]: value,
            },
        });
    };

    const handleImageUpload = async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid image file (JPEG, PNG, GIF, or WebP)');
            e.target.value = '';
            return;
        }

        // Validate file size (5MB max)
        const maxSize = 5 * 1024 * 1024; // 5MB in bytes
        if (file.size > maxSize) {
            alert('Image size must be less than 5MB. Please choose a smaller image.');
            e.target.value = '';
            return;
        }

        setUploading(true);

        const formData = new FormData();
        formData.append('file', file);
        formData.append('title', file.name);
        formData.append('alt_text', file.name);

        try {
            const response = await fetch('/admin/media', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
            });

            const result = await response.json();

            if (response.ok && result.media) {
                setData('image_id', result.media.id);
                setPreviewImage(result.media.file_path);
                alert('Image uploaded successfully!');
            } else {
                const errorMessage = result.message || result.error || 'Failed to upload image';
                alert(errorMessage);
                console.error('Upload failed:', result);
            }
        } catch (error) {
            console.error('Upload error:', error);
            alert('Failed to upload image. Please check your connection and try again.');
        } finally {
            setUploading(false);
            e.target.value = '';
        }
    };

    const removeImage = () => {
        setData('image_id', '');
        setPreviewImage(null);
    };

    return (
        <AppLayout>
            <Head title={isEditing ? 'Edit Slider' : 'Create Slider'} />

            <div className="mb-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">
                            {isEditing ? 'Edit Slider' : 'Create New Slider'}
                        </h1>
                        <p className="mt-2 text-gray-600">Manage homepage slider</p>
                    </div>
                    <Link
                        href="/admin/sliders"
                        className="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300"
                    >
                        ← Back
                    </Link>
                </div>
            </div>

            <form onSubmit={handleSubmit}>
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Main Content */}
                    <div className="lg:col-span-2 space-y-6">
                        {/* Multi-language Content */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h2 className="text-lg font-semibold mb-4">Content</h2>

                            <LanguageTabs locales={locales} defaultLocale="en">
                                {(activeLocale) => (
                                    <div className="space-y-4">
                                        <TextInput
                                            label="Title *"
                                            value={data.translations[activeLocale]?.title || ''}
                                            onChange={(e) => updateTranslation(activeLocale, 'title', e.target.value)}
                                            error={errors[`translations.${activeLocale}.title`]}
                                            placeholder="Enter slider title..."
                                        />

                                        <TextInput
                                            label="Subtitle"
                                            value={data.translations[activeLocale]?.subtitle || ''}
                                            onChange={(e) => updateTranslation(activeLocale, 'subtitle', e.target.value)}
                                            error={errors[`translations.${activeLocale}.subtitle`]}
                                            placeholder="Enter subtitle..."
                                        />

                                        <TextArea
                                            label="Description"
                                            value={data.translations[activeLocale]?.description || ''}
                                            onChange={(e) => updateTranslation(activeLocale, 'description', e.target.value)}
                                            error={errors[`translations.${activeLocale}.description`]}
                                            rows={4}
                                            placeholder="Enter description..."
                                        />
                                    </div>
                                )}
                            </LanguageTabs>
                        </div>

                        {/* Button Settings */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h2 className="text-lg font-semibold mb-4">Call to Action Button</h2>

                            <div className="space-y-4">
                                <TextInput
                                    label="Button Text"
                                    value={data.button_text}
                                    onChange={(e) => setData('button_text', e.target.value)}
                                    error={errors.button_text}
                                    placeholder="e.g., Learn More"
                                />

                                <TextInput
                                    label="Button URL"
                                    value={data.button_url}
                                    onChange={(e) => setData('button_url', e.target.value)}
                                    error={errors.button_url}
                                    placeholder="https://example.com or /page-slug"
                                />

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Link Target
                                    </label>
                                    <select
                                        value={data.button_target}
                                        onChange={(e) => setData('button_target', e.target.value)}
                                        className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    >
                                        <option value="_self">Same Window (_self)</option>
                                        <option value="_blank">New Tab (_blank)</option>
                                    </select>
                                    {errors.button_target && (
                                        <p className="mt-1 text-sm text-red-600">{errors.button_target}</p>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Sidebar */}
                    <div className="space-y-6">
                        {/* Status Settings */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h2 className="text-lg font-semibold mb-4">Status</h2>

                            <div className="space-y-4">
                                <div className="flex items-center">
                                    <input
                                        type="checkbox"
                                        id="is_active"
                                        checked={data.is_active}
                                        onChange={(e) => setData('is_active', e.target.checked)}
                                        className="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    />
                                    <label htmlFor="is_active" className="ml-2 block text-sm text-gray-900">
                                        Active
                                    </label>
                                </div>
                                {errors.is_active && (
                                    <p className="text-sm text-red-600">{errors.is_active}</p>
                                )}
                            </div>
                        </div>

                        {/* Slider Settings */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h2 className="text-lg font-semibold mb-4">Settings</h2>

                            <div className="space-y-4">
                                <TextInput
                                    label="Order"
                                    type="number"
                                    value={data.order}
                                    onChange={(e) => setData('order', e.target.value)}
                                    error={errors.order}
                                    placeholder="0"
                                />

                                {/* Image Upload */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Slider Image *
                                    </label>

                                    {previewImage ? (
                                        <div className="relative">
                                            <img
                                                src={previewImage}
                                                alt="Slider"
                                                className="w-full h-48 object-cover rounded-lg"
                                            />
                                            <button
                                                type="button"
                                                onClick={removeImage}
                                                className="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full hover:bg-red-700"
                                            >
                                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    ) : (
                                        <div className="border-2 border-dashed border-gray-300 rounded-lg p-6">
                                            <input
                                                type="file"
                                                id="image"
                                                accept="image/*"
                                                onChange={handleImageUpload}
                                                className="hidden"
                                                disabled={uploading}
                                            />
                                            <label
                                                htmlFor="image"
                                                className="cursor-pointer flex flex-col items-center"
                                            >
                                                <svg className="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span className="text-sm text-gray-600">
                                                    {uploading ? 'Uploading...' : 'Click to upload image'}
                                                </span>
                                            </label>
                                        </div>
                                    )}
                                    {errors.image_id && (
                                        <p className="mt-1 text-sm text-red-600">{errors.image_id}</p>
                                    )}
                                </div>
                            </div>
                        </div>

                        {/* Submit Actions */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <button
                                type="submit"
                                disabled={processing || uploading}
                                className="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:bg-gray-400 transition-colors"
                            >
                                {processing ? 'Saving...' : (isEditing ? 'Update Slider' : 'Create Slider')}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </AppLayout>
    );
}
