import AppLayout from '../../../Layouts/AppLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import TextInput from '../../../Components/TextInput';
import TextArea from '../../../Components/TextArea';
import Select from '../../../Components/Select';
import LanguageTabs from '../../../Components/LanguageTabs';

export default function CategoryForm({ category, translations, parentCategories, locales }) {
    const isEditing = !!category;

    const { data, setData, post: submit, put, processing, errors } = useForm({
        slug: category?.slug || '',
        parent_id: category?.parent_id || '',
        order: category?.order || 0,
        is_active: category?.is_active ?? true,
        translations: translations || {
            en: { name: '', description: '' },
            mn: { name: '', description: '' },
            zh: { name: '', description: '' },
        },
    });

    const handleSubmit = (e) => {
        e.preventDefault();

        if (isEditing) {
            put(`/admin/categories/${category.id}`);
        } else {
            submit('/admin/categories');
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

    return (
        <AppLayout>
            <Head title={isEditing ? 'Edit Category' : 'Create Category'} />

            <div className="mb-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">
                            {isEditing ? 'Edit Category' : 'Create New Category'}
                        </h1>
                        <p className="mt-2 text-gray-600">Multi-language category management</p>
                    </div>
                    <Link
                        href="/admin/categories"
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
                            <h2 className="text-lg font-semibold mb-4">Category Information</h2>

                            <LanguageTabs locales={locales} defaultLocale="en">
                                {(activeLocale) => (
                                    <div className="space-y-4">
                                        <TextInput
                                            label="Name *"
                                            value={data.translations[activeLocale]?.name || ''}
                                            onChange={(e) => updateTranslation(activeLocale, 'name', e.target.value)}
                                            error={errors[`translations.${activeLocale}.name`]}
                                            placeholder="Enter category name..."
                                        />

                                        <TextArea
                                            label="Description"
                                            value={data.translations[activeLocale]?.description || ''}
                                            onChange={(e) => updateTranslation(activeLocale, 'description', e.target.value)}
                                            error={errors[`translations.${activeLocale}.description`]}
                                            rows={4}
                                            placeholder="Category description..."
                                        />
                                    </div>
                                )}
                            </LanguageTabs>
                        </div>
                    </div>

                    {/* Sidebar */}
                    <div className="space-y-6">
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
                                        placeholder="category-url-slug"
                                    />
                                    <button
                                        type="button"
                                        onClick={generateSlug}
                                        className="mt-2 text-sm text-blue-600 hover:text-blue-800"
                                    >
                                        Generate from name
                                    </button>
                                </div>

                                <Select
                                    label="Parent Category"
                                    value={data.parent_id}
                                    onChange={(e) => setData('parent_id', e.target.value)}
                                    options={[
                                        { value: '', label: 'None (Top Level)' },
                                        ...parentCategories.map((cat) => ({
                                            value: cat.id,
                                            label: cat.name,
                                        })),
                                    ]}
                                    error={errors.parent_id}
                                />

                                <TextInput
                                    label="Order"
                                    type="number"
                                    value={data.order}
                                    onChange={(e) => setData('order', e.target.value)}
                                    error={errors.order}
                                    placeholder="0"
                                />

                                <div className="flex items-center">
                                    <input
                                        id="is_active"
                                        type="checkbox"
                                        checked={data.is_active}
                                        onChange={(e) => setData('is_active', e.target.checked)}
                                        className="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    />
                                    <label htmlFor="is_active" className="ml-2 block text-sm text-gray-900">
                                        Active
                                    </label>
                                </div>
                                {errors.is_active && (
                                    <p className="mt-1 text-sm text-red-600">{errors.is_active}</p>
                                )}
                            </div>
                        </div>

                        {/* Actions */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <button
                                type="submit"
                                disabled={processing}
                                className="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                            >
                                {processing ? 'Saving...' : (isEditing ? 'Update Category' : 'Create Category')}
                            </button>

                            {isEditing && (
                                <Link
                                    href="/admin/categories"
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
