import AppLayout from '../../../Layouts/AppLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import TextInput from '../../../Components/TextInput';
import TextArea from '../../../Components/TextArea';
import LanguageTabs from '../../../Components/LanguageTabs';

export default function TeamMemberForm({ teamMember, translations, locales }) {
    const isEditing = !!teamMember;
    const [uploading, setUploading] = useState(false);
    const [previewImage, setPreviewImage] = useState(teamMember?.photo?.file_path || null);

    // Update preview image when teamMember prop changes
    useEffect(() => {
        setPreviewImage(teamMember?.photo?.file_path || null);
    }, [teamMember?.photo?.file_path]);

    const { data, setData, post: submit, put, processing, errors } = useForm({
        slug: teamMember?.slug || '',
        email: teamMember?.email || '',
        phone: teamMember?.phone || '',
        facebook: teamMember?.facebook || '',
        twitter: teamMember?.twitter || '',
        linkedin: teamMember?.linkedin || '',
        photo_id: teamMember?.photo_id || '',
        is_active: teamMember?.is_active ?? true,
        order: teamMember?.order || 0,
        translations: translations || {
            en: { name: '', position: '', bio: '' },
            mn: { name: '', position: '', bio: '' },
            zh: { name: '', position: '', bio: '' },
        },
    });

    const handleSubmit = (e) => {
        e.preventDefault();

        if (isEditing) {
            put(`/admin/team/${teamMember.id}`);
        } else {
            submit('/admin/team');
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

    const generateSlug = () => {
        const name = data.translations.en.name;
        const slug = name
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');
        setData('slug', slug);
    };

    const handleImageUpload = async (e) => {
        const file = e.target.files[0];
        if (!file) return;

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
                setData('photo_id', result.media.id);
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
        setData('photo_id', '');
        setPreviewImage(null);
    };

    return (
        <AppLayout>
            <Head title={isEditing ? 'Edit Team Member' : 'Create Team Member'} />

            <div className="mb-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">
                            {isEditing ? 'Edit Team Member' : 'Create New Team Member'}
                        </h1>
                        <p className="mt-2 text-gray-600">Multi-language team member management</p>
                    </div>
                    <Link
                        href="/admin/team"
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
                            <h2 className="text-lg font-semibold mb-4">Team Member Information</h2>

                            <LanguageTabs locales={locales} defaultLocale="en">
                                {(activeLocale) => (
                                    <div className="space-y-4">
                                        <TextInput
                                            label="Name *"
                                            value={data.translations[activeLocale]?.name || ''}
                                            onChange={(e) => updateTranslation(activeLocale, 'name', e.target.value)}
                                            error={errors[`translations.${activeLocale}.name`]}
                                            placeholder="Enter member name..."
                                        />

                                        <TextInput
                                            label="Position *"
                                            value={data.translations[activeLocale]?.position || ''}
                                            onChange={(e) => updateTranslation(activeLocale, 'position', e.target.value)}
                                            error={errors[`translations.${activeLocale}.position`]}
                                            placeholder="e.g., CEO, Developer, Designer..."
                                        />

                                        <TextArea
                                            label="Bio"
                                            value={data.translations[activeLocale]?.bio || ''}
                                            onChange={(e) => updateTranslation(activeLocale, 'bio', e.target.value)}
                                            error={errors[`translations.${activeLocale}.bio`]}
                                            rows={6}
                                            placeholder="Brief biography or description..."
                                        />
                                    </div>
                                )}
                            </LanguageTabs>
                        </div>

                        {/* Contact & Social Media */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h2 className="text-lg font-semibold mb-4">Contact & Social Media</h2>

                            <div className="space-y-4">
                                <TextInput
                                    label="Email"
                                    type="email"
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                    error={errors.email}
                                    placeholder="member@example.com"
                                />

                                <TextInput
                                    label="Phone"
                                    value={data.phone}
                                    onChange={(e) => setData('phone', e.target.value)}
                                    error={errors.phone}
                                    placeholder="+976 9999 9999"
                                />

                                <TextInput
                                    label="Facebook URL"
                                    value={data.facebook}
                                    onChange={(e) => setData('facebook', e.target.value)}
                                    error={errors.facebook}
                                    placeholder="https://facebook.com/username"
                                />

                                <TextInput
                                    label="Twitter URL"
                                    value={data.twitter}
                                    onChange={(e) => setData('twitter', e.target.value)}
                                    error={errors.twitter}
                                    placeholder="https://twitter.com/username"
                                />

                                <TextInput
                                    label="LinkedIn URL"
                                    value={data.linkedin}
                                    onChange={(e) => setData('linkedin', e.target.value)}
                                    error={errors.linkedin}
                                    placeholder="https://linkedin.com/in/username"
                                />
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

                        {/* Settings */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h2 className="text-lg font-semibold mb-4">Settings</h2>

                            <div className="space-y-4">
                                <div>
                                    <TextInput
                                        label="Slug *"
                                        value={data.slug}
                                        onChange={(e) => setData('slug', e.target.value)}
                                        error={errors.slug}
                                        placeholder="member-url-slug"
                                    />
                                    <button
                                        type="button"
                                        onClick={generateSlug}
                                        className="mt-2 text-sm text-blue-600 hover:text-blue-800"
                                    >
                                        Generate from name
                                    </button>
                                </div>

                                <TextInput
                                    label="Order"
                                    type="number"
                                    value={data.order}
                                    onChange={(e) => setData('order', e.target.value)}
                                    error={errors.order}
                                    placeholder="0"
                                />

                                {/* Photo Upload */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Photo
                                    </label>

                                    {previewImage ? (
                                        <div className="relative">
                                            <img
                                                src={previewImage}
                                                alt="Photo"
                                                className="w-full h-48 object-cover rounded-lg"
                                            />
                                            <button
                                                type="button"
                                                onClick={removeImage}
                                                className="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full hover:bg-red-700 transition"
                                                title="Remove photo"
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
                                                id="photo-upload"
                                                disabled={uploading}
                                            />
                                            <label
                                                htmlFor="photo-upload"
                                                className="cursor-pointer"
                                            >
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
                                                            Click to upload photo
                                                        </p>
                                                        <p className="mt-1 text-xs text-gray-500">
                                                            PNG, JPG, GIF up to 10MB
                                                        </p>
                                                    </>
                                                )}
                                            </label>
                                        </div>
                                    )}
                                    {errors.photo_id && (
                                        <p className="mt-1 text-sm text-red-600">{errors.photo_id}</p>
                                    )}
                                </div>
                            </div>
                        </div>

                        {/* Actions */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <button
                                type="submit"
                                disabled={processing}
                                className="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                            >
                                {processing ? 'Saving...' : (isEditing ? 'Update Team Member' : 'Create Team Member')}
                            </button>

                            {isEditing && (
                                <Link
                                    href={`/admin/team`}
                                    className="block w-full mt-2 px-4 py-2 text-center bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300"
                                >
                                    Cancel
                                </Link>
                            )}
                        </div>
                    </div>
                </div>
            </form>
        </AppLayout>
    );
}
