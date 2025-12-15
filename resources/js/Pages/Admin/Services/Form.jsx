import AppLayout from "../../../Layouts/AppLayout";
import { Head, useForm } from "@inertiajs/react";
import { useState } from "react";
import TextInput from "../../../Components/TextInput";
import TextArea from "../../../Components/TextArea";
import EditorSwitcher from '../../../Components/EditorSwitcher';
import Select from "../../../Components/Select";
import LanguageTabs from "../../../Components/LanguageTabs";

export default function ServiceForm({ service, sections: initialSections, translations, locales, widgets, selectedWidgets, featuredImage }) {
    const isEditing = !!service;
    const [sections, setSections] = useState(initialSections || []);
    const [selectedWidgetIds, setSelectedWidgetIds] = useState(selectedWidgets || []);
    const [uploadingImage, setUploadingImage] = useState(false);
    const [imagePreview, setImagePreview] = useState(featuredImage?.file_path || null);

    const {
        data,
        setData,
        post: submit,
        put,
        processing,
        errors,
    } = useForm({
        slug: service?.slug || "",
        icon: service?.icon || "",
        featured_image_id: service?.featured_image_id || null,
        is_active: service?.is_active !== undefined ? service.is_active : true,
        order: service?.order || 0,
        sections: initialSections || [],
        widgets: selectedWidgets || [],
        translations: translations || {
            en: { title: "", description: "", content: "" },
            mn: { title: "", description: "", content: "" },
            zh: { title: "", description: "", content: "" },
        },
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        if (isEditing) {
            put(`/admin/services/${service.id}`);
        } else {
            submit("/admin/services");
        }
    };

    const updateTranslation = (locale, field, value) => {
        setData("translations", {
            ...data.translations,
            [locale]: { ...data.translations[locale], [field]: value },
        });
    };

    const addSection = (type) => {
        const newSection = {
            type: type,
            icon: "",
            order: sections.length,
            is_active: true,
            translations: {
                en: { title: "", content: "" },
                mn: { title: "", content: "" },
                zh: { title: "", content: "" },
            },
        };
        const updated = [...sections, newSection];
        setSections(updated);
        setData("sections", updated);
    };

    const removeSection = (index) => {
        const updated = sections.filter((_, i) => i !== index);
        setSections(updated);
        setData("sections", updated);
    };

    const updateSectionTranslation = (sectionIndex, locale, field, value) => {
        const updated = sections.map((section, i) => {
            if (i === sectionIndex) {
                return {
                    ...section,
                    translations: {
                        ...section.translations,
                        [locale]: { ...section.translations[locale], [field]: value },
                    },
                };
            }
            return section;
        });
        setSections(updated);
        setData("sections", updated);
    };

    const toggleWidget = (widgetId) => {
        const updated = selectedWidgetIds.includes(widgetId)
            ? selectedWidgetIds.filter(id => id !== widgetId)
            : [...selectedWidgetIds, widgetId];
        setSelectedWidgetIds(updated);
        setData("widgets", updated);
    };

    const handleImageUpload = async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        setUploadingImage(true);
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
                setImagePreview(result.media.file_path);
            } else {
                alert('Failed to upload image');
            }
        } catch (error) {
            console.error('Upload error:', error);
            alert('Failed to upload image');
        } finally {
            setUploadingImage(false);
        }
    };

    const removeImage = () => {
        setData('featured_image_id', null);
        setImagePreview(null);
    };

    return (
        <AppLayout>
            <Head title={isEditing ? "Edit Service" : "Create Service"} />
            
            <div className="mb-6">
                <h1 className="text-3xl font-bold text-gray-900">
                    {isEditing ? "Edit Service" : "Create New Service"}
                </h1>
            </div>

            <form onSubmit={handleSubmit}>
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Main Content */}
                    <div className="lg:col-span-2 space-y-6">
                        {/* Translations */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h2 className="text-xl font-semibold mb-4">Service Information</h2>
                            <LanguageTabs locales={locales}>
                                {(locale) => (
                                    <div className="space-y-4">
                                        <TextInput
                                            label="Title"
                                            value={data.translations[locale]?.title || ""}
                                            onChange={(e) => updateTranslation(locale, "title", e.target.value)}
                                            error={errors[`translations.${locale}.title`]}
                                        />
                                        <TextArea
                                            label="Description"
                                            value={data.translations[locale]?.description || ""}
                                            onChange={(e) => updateTranslation(locale, "description", e.target.value)}
                                            rows={3}
                                        />
                                        <EditorSwitcher
                                            label="Content"
                                            value={data.translations[locale]?.content || ""}
                                            onChange={(value) => updateTranslation(locale, "content", value)}
                                        />
                                    </div>
                                )}
                            </LanguageTabs>
                        </div>

                        {/* Sections */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <div className="flex justify-between items-center mb-4">
                                <h2 className="text-xl font-semibold">Additional Sections</h2>
                                <div className="space-x-2">
                                    <button type="button" onClick={() => addSection('content')} className="px-3 py-1 bg-purple-600 text-white rounded hover:bg-purple-700">Add Content</button>
                                    <button type="button" onClick={() => addSection('tab')} className="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">Add Tab</button>
                                    <button type="button" onClick={() => addSection('accordion')} className="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Add Accordion</button>
                                </div>
                            </div>
                            {sections.map((section, index) => (
                                <div key={index} className="border p-4 rounded mb-4">
                                    <div className="flex justify-between mb-2">
                                        <span className="font-semibold">
                                            {section.type === 'tab' ? 'Tab' : section.type === 'accordion' ? 'Accordion' : 'Content'} #{index + 1}
                                        </span>
                                        <button type="button" onClick={() => removeSection(index)} className="text-red-600 hover:text-red-800">Remove</button>
                                    </div>
                                    <LanguageTabs locales={locales}>
                                        {(locale) => (
                                            <div className="space-y-2">
                                                <TextInput label="Title" value={section.translations[locale]?.title || ""} onChange={(e) => updateSectionTranslation(index, locale, "title", e.target.value)} />
                                                <EditorSwitcher label="Content" value={section.translations[locale]?.content || ""} onChange={(value) => updateSectionTranslation(index, locale, "content", value)} />
                                            </div>
                                        )}
                                    </LanguageTabs>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* Sidebar */}
                    <div className="lg:col-span-1 space-y-6">
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h2 className="text-xl font-semibold mb-4">Settings</h2>
                            <div className="space-y-4">
                                <TextInput label="Slug" value={data.slug} onChange={(e) => setData("slug", e.target.value)} error={errors.slug} />
                                <TextInput label="Icon" value={data.icon} onChange={(e) => setData("icon", e.target.value)} />
                                <Select label="Status" value={data.is_active ? "1" : "0"} onChange={(e) => setData("is_active", e.target.value === "1")} options={[{value: "1", label: "Active"}, {value: "0", label: "Inactive"}]} />
                                <TextInput label="Order" type="number" value={data.order} onChange={(e) => setData("order", e.target.value)} />
                            </div>
                        </div>

                        {/* Featured Image */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h2 className="text-xl font-semibold mb-4">Featured Image</h2>
                            {imagePreview ? (
                                <div className="mb-3 relative">
                                    <img
                                        src={imagePreview}
                                        alt="Featured"
                                        className="h-32 w-auto object-contain border border-gray-300 rounded cursor-pointer hover:border-blue-400 transition-colors"
                                        onClick={() => document.getElementById('featured-image-input').click()}
                                        title="Click to change image"
                                    />
                                    <button type="button" onClick={removeImage} className="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors shadow-md">×</button>
                                </div>
                            ) : (
                                <div className="mb-3 border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-500 transition-colors" onClick={() => document.getElementById('featured-image-input').click()}>
                                    <svg className="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p className="mt-2 text-sm text-gray-600">Click to upload image</p>
                                </div>
                            )}
                            <input id="featured-image-input" type="file" accept="image/*" onChange={handleImageUpload} disabled={uploadingImage} className="hidden" />
                            {uploadingImage && <p className="mt-2 text-sm text-gray-500">Uploading...</p>}
                            {errors.featured_image_id && <p className="mt-2 text-sm text-red-600">{errors.featured_image_id}</p>}
                        </div>

                        {/* Widgets */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h2 className="text-xl font-semibold mb-4">Widgets</h2>
                            {widgets.map(widget => (
                                <label key={widget.id} className="flex items-center space-x-2 mb-2">
                                    <input type="checkbox" checked={selectedWidgetIds.includes(widget.id)} onChange={() => toggleWidget(widget.id)} />
                                    <span>{widget.title}</span>
                                </label>
                            ))}
                        </div>

                        <button type="submit" disabled={processing} className="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            {processing ? "Saving..." : isEditing ? "Update Service" : "Create Service"}
                        </button>
                    </div>
                </div>
            </form>
        </AppLayout>
    );
}
