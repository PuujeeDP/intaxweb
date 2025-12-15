import AppLayout from "../../../Layouts/AppLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import { useState } from "react";
import TextInput from "../../../Components/TextInput";
import TextArea from "../../../Components/TextArea";
import EditorSwitcher from '../../../Components/EditorSwitcher';
import Select from "../../../Components/Select";
import LanguageTabs from "../../../Components/LanguageTabs";

export default function PageForm({ page, sections: initialSections, translations, locales, headerImage }) {
    const isEditing = !!page;
    const [sections, setSections] = useState(initialSections || []);
    const [uploadingHeaderImage, setUploadingHeaderImage] = useState(false);
    const [headerImagePreview, setHeaderImagePreview] = useState(headerImage?.file_path || null);

    const {
        data,
        setData,
        post: submit,
        put,
        processing,
        errors,
    } = useForm({
        slug: page?.slug || "",
        template: page?.template || "default",
        header_image_id: page?.header_image_id || null,
        hide_title: page?.hide_title || false,
        status: page?.status || "draft",
        published_at: page?.published_at || "",
        sections: initialSections || [],
        order: page?.order || 0,
        translations: translations || {
            en: {
                title: "",
                content: "",
                meta_title: "",
                meta_description: "",
            },
            mn: {
                title: "",
                content: "",
                meta_title: "",
                meta_description: "",
            },
            zh: {
                title: "",
                content: "",
                meta_title: "",
                meta_description: "",
            },
        },
    });

    const handleSubmit = (e) => {
        e.preventDefault();

        // Debug logging
        console.log('Form data being submitted:', data);
        console.log('Sections array:', data.sections);
        console.log('Sections count:', data.sections?.length);

        if (isEditing) {
            put(`/admin/pages/${page.id}`);
        } else {
            submit("/admin/pages");
        }
    };

    const updateTranslation = (locale, field, value) => {
        setData("translations", {
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
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/(^-|-$)/g, "");
        setData("slug", slug);
    };

    const addSection = (type) => {
        const newSection = {
            type: type, // 'tab' or 'accordion'
            icon: "",
            order: sections.length,
            is_active: true,
            translations: {
                en: { title: "", content: "" },
                mn: { title: "", content: "" },
                zh: { title: "", content: "" },
            },
        };
        setSections([...sections, newSection]);
        setData("sections", [...sections, newSection]);
    };

    const handleHeaderImageUpload = async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        setUploadingHeaderImage(true);

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
                setData('header_image_id', result.media.id);
                setHeaderImagePreview(result.media.file_path);
            } else {
                alert('Failed to upload image');
            }
        } catch (error) {
            console.error('Upload error:', error);
            alert('Failed to upload image');
        } finally {
            setUploadingHeaderImage(false);
        }
    };

    const removeHeaderImage = () => {
        setData('header_image_id', null);
        setHeaderImagePreview(null);
    };

    return (
        <AppLayout>
            <Head title={isEditing ? "Edit Page" : "Create Page"} />

            <div className="mb-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">
                            {isEditing ? "Edit Page" : "Create New Page"}
                        </h1>
                        <p className="mt-2 text-gray-600">
                            Multi-language page management
                        </p>
                    </div>
                    <Link
                        href="/admin/pages"
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
                            <h2 className="text-lg font-semibold mb-4">
                                Content
                            </h2>

                            <LanguageTabs locales={locales} defaultLocale="en">
                                {(activeLocale) => (
                                    <div className="space-y-4">
                                        <TextInput
                                            label="Title *"
                                            value={
                                                data.translations[activeLocale]
                                                    ?.title || ""
                                            }
                                            onChange={(e) =>
                                                updateTranslation(
                                                    activeLocale,
                                                    "title",
                                                    e.target.value
                                                )
                                            }
                                            error={
                                                errors[
                                                    `translations.${activeLocale}.title`
                                                ]
                                            }
                                            placeholder="Enter page title..."
                                        />

                                        <EditorSwitcher
                                            label="Content *"
                                            value={
                                                data.translations[activeLocale]
                                                    ?.content || ""
                                            }
                                            onChange={(content) =>
                                                updateTranslation(
                                                    activeLocale,
                                                    "content",
                                                    content
                                                )
                                            }
                                            error={
                                                errors[
                                                    `translations.${activeLocale}.content`
                                                ]
                                            }
                                            height={500}
                                        />
                                    </div>
                                )}
                            </LanguageTabs>
                        </div>

                        <div className="bg-white rounded-lg shadow-md p-6 mt-6">
                            <div className="flex justify-between items-center mb-4">
                                <h2 className="text-lg font-semibold">
                                    Page Sections
                                </h2>
                                <div className="space-x-2">
                                    <button
                                        type="button"
                                        onClick={() => addSection("tab")}
                                        className="px-4 py-2 bg-blue-600 text-white rounded"
                                    >
                                        + Add Tab Section
                                    </button>
                                    <button
                                        type="button"
                                        onClick={() => addSection("accordion")}
                                        className="px-4 py-2 bg-green-600 text-white rounded"
                                    >
                                        + Add Accordion Section
                                    </button>
                                </div>
                            </div>

                            {sections.length > 0 && sections.map((section, index) => (
                                <div key={index} className="border-t border-gray-200 pt-4 mt-4">
                                    <div className="flex justify-between items-center mb-3">
                                        <h3 className="font-semibold">Section {index + 1} ({section.type})</h3>
                                        <button type="button" onClick={() => {
                                            const newSections = sections.filter((_, i) => i !== index);
                                            setSections(newSections);
                                            setData('sections', newSections);
                                        }} className="text-red-600 hover:text-red-800">Remove</button>
                                    </div>
                                    <LanguageTabs locales={locales} defaultLocale="en">
                                        {(activeLocale) => (
                                            <div className="space-y-4">
                                                <TextInput
                                                    label="Section Title *"
                                                    value={section.translations[activeLocale]?.title || ''}
                                                    onChange={(e) => {
                                                        const newSections = [...sections];
                                                        newSections[index].translations[activeLocale].title = e.target.value;
                                                        setSections(newSections);
                                                        setData('sections', newSections);
                                                    }}
                                                    placeholder="Enter section title..."
                                                />
                                                <EditorSwitcher
                                                    label="Section Content *"
                                                    value={section.translations[activeLocale]?.content || ''}
                                                    onChange={(content) => {
                                                        const newSections = [...sections];
                                                        newSections[index].translations[activeLocale].content = content;
                                                        setSections(newSections);
                                                        setData('sections', newSections);
                                                    }}
                                                    height={300}
                                                />
                                            </div>
                                        )}
                                    </LanguageTabs>
                                </div>
                            ))}
                        </div>

                        {/* SEO Settings */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h2 className="text-lg font-semibold mb-4">
                                SEO Settings
                            </h2>

                            <LanguageTabs locales={locales} defaultLocale="en">
                                {(activeLocale) => (
                                    <div className="space-y-4">
                                        <TextInput
                                            label="Meta Title"
                                            value={
                                                data.translations[activeLocale]
                                                    ?.meta_title || ""
                                            }
                                            onChange={(e) =>
                                                updateTranslation(
                                                    activeLocale,
                                                    "meta_title",
                                                    e.target.value
                                                )
                                            }
                                            error={
                                                errors[
                                                    `translations.${activeLocale}.meta_title`
                                                ]
                                            }
                                            placeholder="SEO title..."
                                        />

                                        <TextArea
                                            label="Meta Description"
                                            value={
                                                data.translations[activeLocale]
                                                    ?.meta_description || ""
                                            }
                                            onChange={(e) =>
                                                updateTranslation(
                                                    activeLocale,
                                                    "meta_description",
                                                    e.target.value
                                                )
                                            }
                                            error={
                                                errors[
                                                    `translations.${activeLocale}.meta_description`
                                                ]
                                            }
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
                            <h2 className="text-lg font-semibold mb-4">
                                Publish
                            </h2>

                            <div className="space-y-4">
                                <Select
                                    label="Status"
                                    value={data.status}
                                    onChange={(e) =>
                                        setData("status", e.target.value)
                                    }
                                    options={[
                                        { value: "draft", label: "Draft" },
                                        {
                                            value: "published",
                                            label: "Published",
                                        },
                                        {
                                            value: "archived",
                                            label: "Archived",
                                        },
                                    ]}
                                    error={errors.status}
                                />

                                <TextInput
                                    label="Publish Date"
                                    type="datetime-local"
                                    value={data.published_at}
                                    onChange={(e) =>
                                        setData("published_at", e.target.value)
                                    }
                                    error={errors.published_at}
                                />
                            </div>
                        </div>

                        {/* Page Settings */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h2 className="text-lg font-semibold mb-4">
                                Settings
                            </h2>

                            <div className="space-y-4">
                                <div>
                                    <TextInput
                                        label="Slug *"
                                        value={data.slug}
                                        onChange={(e) =>
                                            setData("slug", e.target.value)
                                        }
                                        error={errors.slug}
                                        placeholder="page-url-slug"
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
                                    label="Template"
                                    value={data.template}
                                    onChange={(e) =>
                                        setData("template", e.target.value)
                                    }
                                    options={[
                                        { value: "default", label: "Default (With Sidebar)" },
                                        { value: "full-width", label: "Full Width (No Sidebar)" },
                                    ]}
                                    error={errors.template}
                                />

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Header Image
                                    </label>
                                    {headerImagePreview && (
                                        <div className="mb-3 relative inline-block">
                                            <img
                                                src={headerImagePreview}
                                                alt="Header"
                                                className="h-32 w-auto object-contain border border-gray-300 rounded"
                                            />
                                            <button
                                                type="button"
                                                onClick={removeHeaderImage}
                                                className="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors"
                                            >
                                                ×
                                            </button>
                                        </div>
                                    )}
                                    <input
                                        type="file"
                                        accept="image/*"
                                        onChange={handleHeaderImageUpload}
                                        disabled={uploadingHeaderImage}
                                        className="block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-blue-50 file:text-blue-700
                                            hover:file:bg-blue-100
                                            disabled:opacity-50 disabled:cursor-not-allowed"
                                    />
                                    {uploadingHeaderImage && (
                                        <p className="mt-2 text-sm text-gray-500">Uploading...</p>
                                    )}
                                    {errors.header_image_id && (
                                        <p className="mt-2 text-sm text-red-600">{errors.header_image_id}</p>
                                    )}
                                </div>

                                <div className="flex items-center">
                                    <input
                                        type="checkbox"
                                        id="hide_title"
                                        checked={data.hide_title}
                                        onChange={(e) => setData("hide_title", e.target.checked)}
                                        className="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2"
                                    />
                                    <label htmlFor="hide_title" className="ml-2 text-sm font-medium text-gray-700">
                                        Hide Title / Гарчиг нуух
                                    </label>
                                </div>

                                <TextInput
                                    label="Order"
                                    type="number"
                                    value={data.order}
                                    onChange={(e) =>
                                        setData("order", e.target.value)
                                    }
                                    error={errors.order}
                                    placeholder="0"
                                />
                            </div>
                        </div>

                        {/* Actions */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <button
                                type="submit"
                                disabled={processing}
                                className="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                            >
                                {processing
                                    ? "Saving..."
                                    : isEditing
                                    ? "Update Page"
                                    : "Create Page"}
                            </button>

                            {isEditing && (
                                <Link
                                    href={`/admin/pages`}
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
