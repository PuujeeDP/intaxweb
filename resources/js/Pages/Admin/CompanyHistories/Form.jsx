import { useState } from 'react';
import LanguageTabs from '@/Components/LanguageTabs';
import EditorSwitcher from '@/Components/EditorSwitcher';

export default function Form({ history, onSubmit, processing, locales = { en: 'English', mn: 'Монгол', zh: '中文' } }) {
    const [formData, setFormData] = useState({
        year: history?.year || '',
        translations: {
            en: {
                title: history?.title_en || '',
                description: history?.description_en || ''
            },
            mn: {
                title: history?.title_mn || '',
                description: history?.description_mn || ''
            },
            zh: {
                title: history?.title_zh || '',
                description: history?.description_zh || ''
            }
        },
        image_id: history?.image_id || '',
        is_active: history?.is_active ?? true,
        order: history?.order || 0,
    });

    const [errors, setErrors] = useState({});
    const [uploading, setUploading] = useState(false);
    const [previewImage, setPreviewImage] = useState(history?.image?.file_path || null);

    const handleSubmit = (e) => {
        e.preventDefault();

        // Transform data for backend
        const submitData = {
            year: formData.year,
            title_en: formData.translations.en.title,
            title_mn: formData.translations.mn.title,
            title_zh: formData.translations.zh.title,
            description_en: formData.translations.en.description,
            description_mn: formData.translations.mn.description,
            description_zh: formData.translations.zh.description,
            image_id: formData.image_id,
            is_active: formData.is_active,
            order: formData.order,
        };

        onSubmit(submitData, setErrors);
    };

    const updateTranslation = (locale, field, value) => {
        setFormData((prev) => ({
            ...prev,
            translations: {
                ...prev.translations,
                [locale]: {
                    ...prev.translations[locale],
                    [field]: value
                }
            }
        }));
    };

    const handleImageUpload = async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        setUploading(true);

        const formDataUpload = new FormData();
        formDataUpload.append('file', file);
        formDataUpload.append('title', file.name);
        formDataUpload.append('alt_text', file.name);

        try {
            const response = await fetch('/admin/media', {
                method: 'POST',
                body: formDataUpload,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
            });

            const result = await response.json();

            if (response.ok && result.media) {
                setFormData({ ...formData, image_id: result.media.id });
                setPreviewImage(result.media.file_path);
            } else {
                alert('Failed to upload image');
            }
        } catch (error) {
            console.error('Upload error:', error);
            alert('Failed to upload image');
        } finally {
            setUploading(false);
        }
    };

    const removeImage = () => {
        setFormData({ ...formData, image_id: '' });
        setPreviewImage(null);
    };

    return (
        <form onSubmit={handleSubmit} className="space-y-6">
            {/* Year */}
            <div>
                <label htmlFor="year" className="block text-sm font-medium text-gray-700">
                    Year *
                </label>
                <input
                    type="number"
                    id="year"
                    value={formData.year}
                    onChange={(e) => setFormData({ ...formData, year: e.target.value })}
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required
                />
                {errors.year && <p className="mt-1 text-sm text-red-600">{errors.year}</p>}
            </div>

            {/* Title - Multi-language */}
            <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                <LanguageTabs locales={locales} defaultLocale="en">
                    {(activeLocale) => (
                        <div>
                            <input
                                type="text"
                                value={formData.translations[activeLocale]?.title || ''}
                                onChange={(e) => updateTranslation(activeLocale, 'title', e.target.value)}
                                placeholder={`Enter title in ${locales[activeLocale]}`}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required
                            />
                            {errors[`title_${activeLocale}`] && (
                                <p className="mt-1 text-sm text-red-600">{errors[`title_${activeLocale}`]}</p>
                            )}
                        </div>
                    )}
                </LanguageTabs>
            </div>

            {/* Description - Multi-language */}
            <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                <LanguageTabs locales={locales} defaultLocale="en">
                    {(activeLocale) => (
                        <div>
                            <EditorSwitcher
                                value={formData.translations[activeLocale]?.description || ''}
                                onChange={(content) => updateTranslation(activeLocale, 'description', content)}
                                error={errors[`description_${activeLocale}`]}
                                height={400}
                            />
                        </div>
                    )}
                </LanguageTabs>
            </div>

            {/* Image Upload */}
            <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                    Image
                </label>
                <div className="space-y-4">
                    {previewImage ? (
                        <div className="relative inline-block">
                            <img
                                src={previewImage}
                                alt="Preview"
                                className="h-48 w-auto rounded-lg shadow-md object-cover"
                            />
                            <button
                                type="button"
                                onClick={removeImage}
                                className="absolute -top-2 -right-2 bg-red-600 text-white rounded-full p-2 hover:bg-red-700 shadow-lg"
                                title="Remove image"
                            >
                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    ) : (
                        <div className="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition">
                            <input
                                type="file"
                                accept="image/*"
                                onChange={handleImageUpload}
                                className="hidden"
                                id="image-upload"
                                disabled={uploading}
                            />
                            <label htmlFor="image-upload" className="cursor-pointer">
                                {uploading ? (
                                    <div className="text-gray-500">
                                        <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto mb-2"></div>
                                        <p className="text-sm">Uploading...</p>
                                    </div>
                                ) : (
                                    <>
                                        <svg
                                            className="mx-auto h-12 w-12 text-gray-400"
                                            stroke="currentColor"
                                            fill="none"
                                            viewBox="0 0 48 48"
                                        >
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                strokeWidth={2}
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                            />
                                        </svg>
                                        <p className="mt-2 text-sm text-gray-600">
                                            Click to upload or drag and drop
                                        </p>
                                        <p className="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </>
                                )}
                            </label>
                        </div>
                    )}
                </div>
                {errors.image_id && <p className="mt-1 text-sm text-red-600">{errors.image_id}</p>}
            </div>

            {/* Order */}
            <div>
                <label htmlFor="order" className="block text-sm font-medium text-gray-700">
                    Order
                </label>
                <input
                    type="number"
                    id="order"
                    value={formData.order}
                    onChange={(e) => setFormData({ ...formData, order: e.target.value })}
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                />
                {errors.order && <p className="mt-1 text-sm text-red-600">{errors.order}</p>}
            </div>

            {/* Is Active */}
            <div className="flex items-center">
                <input
                    type="checkbox"
                    id="is_active"
                    checked={formData.is_active}
                    onChange={(e) => setFormData({ ...formData, is_active: e.target.checked })}
                    className="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                />
                <label htmlFor="is_active" className="ml-2 block text-sm text-gray-900">
                    Active
                </label>
            </div>

            {/* Submit Button */}
            <div className="flex items-center justify-end space-x-3">
                <button
                    type="button"
                    onClick={() => window.history.back()}
                    className="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    disabled={processing}
                    className="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded disabled:opacity-50"
                >
                    {processing ? 'Saving...' : 'Save'}
                </button>
            </div>
        </form>
    );
}
