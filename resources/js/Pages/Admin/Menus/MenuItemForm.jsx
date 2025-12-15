import { useState } from "react";
import LanguageTabs from "@/Components/LanguageTabs";

export default function MenuItemForm({
    initialData,
    availableContent,
    onSubmit,
    onCancel,
}) {
    const [formData, setFormData] = useState(
        initialData || {
            type: "custom",
            linkable_id: null,
            linkable_type: null,
            url: "",
            title: { en: "", mn: "", zh: "" },
            target: "_self",
            icon: "",
            css_class: "",
            navigation_menu_slug: "",
            parent_id: null,
            is_active: true,
        }
    );

    const handleSubmit = (e) => {
        e.preventDefault();
        onSubmit(formData);
    };

    const handleTypeChange = (type) => {
        setFormData({
            ...formData,
            type,
            linkable_id: null,
            linkable_type: null,
            url: type === "custom" || type === "external" ? formData.url : "",
        });
    };

    const handleContentSelect = (e) => {
        const selected = e.target.value.split("|");
        if (selected.length === 2) {
            const [type, id] = selected;
            setFormData({
                ...formData,
                linkable_id: parseInt(id),
                linkable_type: `App\\Models\\${
                    type.charAt(0).toUpperCase() + type.slice(1)
                }`,
            });
        }
    };

    return (
        <form onSubmit={handleSubmit} className="space-y-6">
            {/* Item Type */}
            <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                    Item Type
                </label>
                <div className="grid grid-cols-2 md:grid-cols-5 gap-2">
                    {["page", "post", "category", "custom", "external"].map(
                        (type) => (
                            <button
                                key={type}
                                type="button"
                                onClick={() => handleTypeChange(type)}
                                className={`px-4 py-2 rounded text-sm font-medium ${
                                    formData.type === type
                                        ? "bg-blue-600 text-white"
                                        : "bg-gray-200 text-gray-700 hover:bg-gray-300"
                                }`}
                            >
                                {type.charAt(0).toUpperCase() + type.slice(1)}
                            </button>
                        )
                    )}
                </div>
            </div>

            {/* Content Selection (for page/post/category) */}
            {["page", "post", "category"].includes(formData.type) && (
                <div>
                    <label className="block text-sm font-medium text-gray-700">
                        Select{" "}
                        {formData.type.charAt(0).toUpperCase() +
                            formData.type.slice(1)}
                    </label>
                    <select
                        value={
                            formData.linkable_id
                                ? `${formData.type}|${formData.linkable_id}`
                                : ""
                        }
                        onChange={handleContentSelect}
                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                        <option value="">-- Select {formData.type} --</option>
                        {availableContent[formData.type + "s"]?.map((item) => (
                            <option
                                key={item.id}
                                value={`${formData.type}|${item.id}`}
                            >
                                {item.title}
                            </option>
                        ))}
                    </select>
                </div>
            )}

            {/* Custom URL (for custom/external) */}
            {["custom", "external"].includes(formData.type) && (
                <div>
                    <label className="block text-sm font-medium text-gray-700">
                        URL
                    </label>
                    <input
                        type="text"
                        value={formData.url}
                        onChange={(e) =>
                            setFormData({ ...formData, url: e.target.value })
                        }
                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder={
                            formData.type === "external"
                                ? "https://example.com"
                                : "/custom-page"
                        }
                        required
                    />
                    <p className="mt-1 text-xs text-gray-500">
                        {formData.type === "external"
                            ? "Full URL including http:// or https://"
                            : "Relative URL starting with /"}
                    </p>
                </div>
            )}

            {/* Title (Multi-language) */}
            <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                    Menu Item Title
                </label>
                <LanguageTabs
                    locales={{ en: "English", mn: "Mongolian", zh: "Chinese" }}
                    defaultLocale="en"
                >
                    {(activeLocale) => (
                        <input
                            type="text"
                            value={formData.title[activeLocale] || ""}
                            onChange={(e) =>
                                setFormData({
                                    ...formData,
                                    title: {
                                        ...formData.title,
                                        [activeLocale]: e.target.value,
                                    },
                                })
                            }
                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder={`Enter menu item title in ${
                                activeLocale === "en"
                                    ? "English"
                                    : activeLocale === "mn"
                                    ? "Mongolian"
                                    : "Chinese"
                            }`}
                            required={activeLocale === "en"}
                        />
                    )}
                </LanguageTabs>
            </div>

            {/* Link Target */}
            <div>
                <label className="block text-sm font-medium text-gray-700">
                    Open Link In
                </label>
                <select
                    value={formData.target}
                    onChange={(e) =>
                        setFormData({ ...formData, target: e.target.value })
                    }
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="_self">Same Window</option>
                    <option value="_blank">New Window</option>
                </select>
            </div>

            {/* Icon (Optional) */}
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label className="block text-sm font-medium text-gray-700">
                        Icon (Optional)
                    </label>
                    <input
                        type="text"
                        value={formData.icon}
                        onChange={(e) =>
                            setFormData({ ...formData, icon: e.target.value })
                        }
                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="e.g., 🏠 or icon-home"
                    />
                </div>

                {/* CSS Class (Optional) */}
                <div>
                    <label className="block text-sm font-medium text-gray-700">
                        CSS Class (Optional)
                    </label>
                    <input
                        type="text"
                        value={formData.css_class}
                        onChange={(e) =>
                            setFormData({
                                ...formData,
                                css_class: e.target.value,
                            })
                        }
                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="e.g., highlighted-menu-item"
                    />
                </div>
            </div>

            {/* Navigation Menu Slug (For Top Menu Items) */}
            <div>
                <label className="block text-sm font-medium text-gray-700">
                    Navigation Menu Slug (For Top Menu Items)
                </label>
                <select
                    value={formData.navigation_menu_slug || ""}
                    onChange={(e) =>
                        setFormData({
                            ...formData,
                            navigation_menu_slug: e.target.value,
                        })
                    }
                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">-- Default (primary) --</option>
                    <option value="primary">Primary Menu</option>
                    <option value="audit">Audit Menu</option>
                    <option value="course">Courses Menu</option>
                    <option value="tax">Tax Menu</option>
                    <option value="software">Software Menu</option>
                </select>
                <p className="mt-1 text-xs text-gray-500">
                    When this top menu item is clicked, the selected navigation
                    menu will be displayed below. Leave empty to use the primary
                    menu.
                </p>
            </div>

            {/* Is Active */}
            <div className="flex items-center">
                <input
                    type="checkbox"
                    id="is_active"
                    checked={formData.is_active}
                    onChange={(e) =>
                        setFormData({
                            ...formData,
                            is_active: e.target.checked,
                        })
                    }
                    className="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                />
                <label
                    htmlFor="is_active"
                    className="ml-2 block text-sm text-gray-900"
                >
                    Active (visible on frontend)
                </label>
            </div>

            {/* Submit Buttons */}
            <div className="flex items-center justify-end space-x-3 pt-4 border-t">
                <button
                    type="button"
                    onClick={onCancel}
                    className="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    className="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700"
                >
                    {initialData ? "Update Item" : "Add Item"}
                </button>
            </div>
        </form>
    );
}
