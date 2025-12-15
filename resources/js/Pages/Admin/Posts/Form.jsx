import AppLayout from '../../../Layouts/AppLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import TextInput from '../../../Components/TextInput';
import TextArea from '../../../Components/TextArea';
import EditorSwitcher from '../../../Components/EditorSwitcher';
import Select from '../../../Components/Select';
import LanguageTabs from '../../../Components/LanguageTabs';

export default function PostForm({ post, translations, categories, locales }) {
    const isEditing = !!post;
    const [uploading, setUploading] = useState(false);
    const [previewImage, setPreviewImage] = useState(post?.featured_image?.file_path || null);

    // Update preview image when post prop changes (useful when navigating between posts)
    useEffect(() => {
        setPreviewImage(post?.featured_image?.file_path || null);
    }, [post?.featured_image?.file_path]);

    // Format published_at for datetime-local input (yyyy-MM-ddThh:mm)
    const formatDatetimeLocal = (dateString) => {
        if (!dateString) return '';
        // Convert "2025-10-21T10:02:00.000000Z" to "2025-10-21T10:02"
        return dateString.substring(0, 16);
    };

    const { data, setData, post: submit, put, processing, errors } = useForm({
        slug: post?.slug || '',
        category_id: post?.category_id || '',
        featured_image_id: post?.featured_image_id || '',
        featured_image: null,
        status: post?.status || 'draft',
        published_at: formatDatetimeLocal(post?.published_at) || '',
        translations: translations || {
            en: { title: '', excerpt: '', content: '', meta_title: '', meta_description: '' },
            mn: { title: '', excerpt: '', content: '', meta_title: '', meta_description: '' },
            zh: { title: '', excerpt: '', content: '', meta_title: '', meta_description: '' },
        },
    });

    const handleSubmit = (e) => {
        e.preventDefault();

        if (isEditing) {
            put(`/admin/posts/${post.id}`);
        } else {
            submit('/admin/posts');
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
        const title = data.translations.en.title;
        const slug = title
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
                setData('featured_image_id', result.media.id);
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
        setData('featured_image_id', '');
        setPreviewImage(null);
    };

    return (
        <AppLayout>
            <Head title={isEditing ? 'Edit Post' : 'Create Post'} />

            <div className="mb-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">
                            {isEditing ? 'Edit Post' : 'Create New Post'}
                        </h1>
                        <p className="mt-2 text-gray-600">Multi-language content management</p>
                    </div>
                    <Link
                        href="/admin/posts"
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
                                            placeholder="Enter post title..."
                                        />

                                        <TextArea
                                            label="Excerpt"
                                            value={data.translations[activeLocale]?.excerpt || ''}
                                            onChange={(e) => updateTranslation(activeLocale, 'excerpt', e.target.value)}
                                            error={errors[`translations.${activeLocale}.excerpt`]}
                                            rows={3}
                                            placeholder="Short description..."
                                        />

                                        <EditorSwitcher
                                            label="Content *"
                                            value={data.translations[activeLocale]?.content || ''}
                                            onChange={(content) => updateTranslation(activeLocale, 'content', content)}
                                            error={errors[`translations.${activeLocale}.content`]}
                                            height={500}
                                        />
                                    </div>
                                )}
                            </LanguageTabs>
                        </div>

                        {/* SEO Settings */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h2 className="text-lg font-semibold mb-4">SEO Settings</h2>

                            <LanguageTabs locales={locales} defaultLocale="en">
                                {(activeLocale) => (
                                    <div className="space-y-4">
                                        <TextInput
                                            label="Meta Title"
                                            value={data.translations[activeLocale]?.meta_title || ''}
                                            onChange={(e) => updateTranslation(activeLocale, 'meta_title', e.target.value)}
                                            error={errors[`translations.${activeLocale}.meta_title`]}
                                            placeholder="SEO title..."
                                        />

                                        <TextArea
                                            label="Meta Description"
                                            value={data.translations[activeLocale]?.meta_description || ''}
                                            onChange={(e) => updateTranslation(activeLocale, 'meta_description', e.target.value)}
                                            error={errors[`translations.${activeLocale}.meta_description`]}
                                            rows={3}
                                            placeholder="SEO description..."
                                        />
                                    </div>
                                )}
                            </LanguageTabs>
                        </div>
                    </div>

                    {/* Sidebar */}
                    <div className="space-y-6">
                        {/* Publish Settings */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h2 className="text-lg font-semibold mb-4">Publish</h2>

                            <div className="space-y-4">
                                <Select
                                    label="Status"
                                    value={data.status}
                                    onChange={(e) => setData('status', e.target.value)}
                                    options={[
                                        { value: 'draft', label: 'Draft' },
                                        { value: 'published', label: 'Published' },
                                        { value: 'archived', label: 'Archived' },
                                    ]}
                                    error={errors.status}
                                />

                                <TextInput
                                    label="Publish Date"
                                    type="datetime-local"
                                    value={data.published_at}
                                    onChange={(e) => setData('published_at', e.target.value)}
                                    error={errors.published_at}
                                />
                            </div>
                        </div>

                        {/* Post Settings */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h2 className="text-lg font-semibold mb-4">Settings</h2>

                            <div className="space-y-4">
                                <div>
                                    <TextInput
                                        label="Slug *"
                                        value={data.slug}
                                        onChange={(e) => setData('slug', e.target.value)}
                                        error={errors.slug}
                                        placeholder="post-url-slug"
                                    />
                                    <button
                                        type="button"
                                        onClick={generateSlug}
                                        className="mt-2 text-sm text-blue-600 hover:text-blue-800"
                                    >
                                        Generate from title
                                    </button>
                                </div>

                                <Select
                                    label="Category"
                                    value={data.category_id}
                                    onChange={(e) => setData('category_id', e.target.value)}
                                    options={[
                                        { value: '', label: 'Select category...' },
                                        ...categories.map((cat) => ({
                                            value: cat.id,
                                            label: cat.name,
                                        })),
                                    ]}
                                    error={errors.category_id}
                                />

                                {/* Featured Image Upload */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Featured Image
                                    </label>

                                    {previewImage ? (
                                        <div className="relative">
                                            <img
                                                src={previewImage}
                                                alt="Featured"
                                                className="w-full h-48 object-cover rounded-lg"
                                            />
                                            <button
                                                type="button"
                                                onClick={removeImage}
                                                className="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full hover:bg-red-700 transition"
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
                                                id="featured-image-upload"
                                                disabled={uploading}
                                            />
                                            <label
                                                htmlFor="featured-image-upload"
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
                                                            Click to upload image
                                                        </p>
                                                        <p className="mt-1 text-xs text-gray-500">
                                                            PNG, JPG, GIF up to 10MB
                                                        </p>
                                                    </>
                                                )}
                                            </label>
                                        </div>
                                    )}
                                    {errors.featured_image_id && (
                                        <p className="mt-1 text-sm text-red-600">{errors.featured_image_id}</p>
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
                                {processing ? 'Saving...' : (isEditing ? 'Update Post' : 'Create Post')}
                            </button>

                            {isEditing && (
                                <Link
                                    href={`/admin/posts/${post.id}`}
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
