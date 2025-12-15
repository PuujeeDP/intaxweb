import { useState } from "react";
import { Head, Link, useForm } from "@inertiajs/react";
import AppLayout from "@/Layouts/AppLayout";

export default function Edit({ client }) {
    const { data, setData, put, processing, errors } = useForm({
        name: client.name || "",
        slug: client.slug || "",
        description: client.description || "",
        website: client.website || "",
        logo_id: client.logo_id || null,
        tags: client.tags || [],
        order: client.order || 0,
        is_active: client.is_active ?? true,
    });

    const [tagInput, setTagInput] = useState("");
    const [uploading, setUploading] = useState(false);
    const [previewImage, setPreviewImage] = useState(
        client?.logo?.file_path || null
    );

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route("admin.clients.update", client.id));
    };

    const addTag = () => {
        if (tagInput.trim() && !data.tags.includes(tagInput.trim())) {
            setData("tags", [...data.tags, tagInput.trim()]);
            setTagInput("");
        }
    };

    const removeTag = (tagToRemove) => {
        setData(
            "tags",
            data.tags.filter((tag) => tag !== tagToRemove)
        );
    };

    const handleKeyPress = (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            addTag();
        }
    };

    const handleImageUpload = async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        setUploading(true);
        const formData = new FormData();
        formData.append("file", file);

        try {
            const response = await fetch("/admin/media", {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Accept: "application/json",
                },
                credentials: "same-origin",
            });

            const result = await response.json();

            if (response.ok && result.media) {
                setData("logo_id", result.media.id);
                setPreviewImage(result.media.file_path);
            } else {
                alert("Failed to upload logo");
            }
        } catch (error) {
            console.error("Upload error:", error);
            alert("Failed to upload logo");
        } finally {
            setUploading(false);
        }
    };

    const removeImage = () => {
        setData("logo_id", null);
        setPreviewImage(null);
    };

    return (
        <AppLayout>
            <Head title={`Edit Client: ${client.name}`} />

            <div className="py-12">
                <div className="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            <div className="flex justify-between items-center mb-6">
                                <h2 className="text-2xl font-bold text-gray-800">
                                    Edit Client: {client.name}
                                </h2>
                                <Link
                                    href={route("admin.clients.index")}
                                    className="text-gray-600 hover:text-gray-900"
                                >
                                    Back to List
                                </Link>
                            </div>

                            <form onSubmit={handleSubmit} className="space-y-6">
                                {/* Name */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Client Name *
                                    </label>
                                    <input
                                        type="text"
                                        value={data.name}
                                        onChange={(e) =>
                                            setData("name", e.target.value)
                                        }
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                        required
                                    />
                                    {errors.name && (
                                        <div className="text-red-600 text-sm mt-1">
                                            {errors.name}
                                        </div>
                                    )}
                                </div>

                                {/* Slug */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Slug (optional)
                                    </label>
                                    <input
                                        type="text"
                                        value={data.slug}
                                        onChange={(e) =>
                                            setData("slug", e.target.value)
                                        }
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                        placeholder="auto-generated from name"
                                    />
                                    {errors.slug && (
                                        <div className="text-red-600 text-sm mt-1">
                                            {errors.slug}
                                        </div>
                                    )}
                                </div>

                                {/* Description */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Description
                                    </label>
                                    <textarea
                                        value={data.description}
                                        onChange={(e) =>
                                            setData(
                                                "description",
                                                e.target.value
                                            )
                                        }
                                        rows="3"
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                    />
                                    {errors.description && (
                                        <div className="text-red-600 text-sm mt-1">
                                            {errors.description}
                                        </div>
                                    )}
                                </div>

                                {/* Website */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Website URL
                                    </label>
                                    <input
                                        type="url"
                                        value={data.website}
                                        onChange={(e) =>
                                            setData("website", e.target.value)
                                        }
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                        placeholder="https://example.com"
                                    />
                                    {errors.website && (
                                        <div className="text-red-600 text-sm mt-1">
                                            {errors.website}
                                        </div>
                                    )}
                                </div>

                                {/* Logo Upload */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Logo
                                    </label>
                                    {previewImage ? (
                                        <div className="mb-4">
                                            <img
                                                src={previewImage}
                                                alt="Preview"
                                                className="max-w-xs max-h-40 rounded border"
                                            />
                                            <button
                                                type="button"
                                                onClick={removeImage}
                                                className="mt-2 text-red-600 hover:text-red-800"
                                            >
                                                Remove Logo
                                            </button>
                                        </div>
                                    ) : (
                                        <input
                                            type="file"
                                            accept="image/*"
                                            onChange={handleImageUpload}
                                            disabled={uploading}
                                            className="w-full px-4 py-2 border border-gray-300 rounded-lg"
                                        />
                                    )}
                                    {uploading && (
                                        <p className="text-sm text-gray-500 mt-2">
                                            Uploading...
                                        </p>
                                    )}
                                    {errors.logo_id && (
                                        <div className="text-red-600 text-sm mt-1">
                                            {errors.logo_id}
                                        </div>
                                    )}
                                </div>

                                {/* Tags */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Tags
                                    </label>
                                    <div className="flex gap-2 mb-2">
                                        <input
                                            type="text"
                                            value={tagInput}
                                            onChange={(e) =>
                                                setTagInput(e.target.value)
                                            }
                                            onKeyDown={handleKeyPress}
                                            className="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                            placeholder="Enter tag and press Enter"
                                        />
                                        <button
                                            type="button"
                                            onClick={addTag}
                                            className="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700"
                                        >
                                            Add
                                        </button>
                                    </div>
                                    <div className="flex flex-wrap gap-2">
                                        {data.tags.map((tag, index) => (
                                            <span
                                                key={index}
                                                className="px-3 py-1 bg-blue-100 text-blue-800 rounded-full flex items-center gap-2"
                                            >
                                                {tag}
                                                <button
                                                    type="button"
                                                    onClick={() =>
                                                        removeTag(tag)
                                                    }
                                                    className="text-blue-600 hover:text-blue-900"
                                                >
                                                    ×
                                                </button>
                                            </span>
                                        ))}
                                    </div>
                                    {errors.tags && (
                                        <div className="text-red-600 text-sm mt-1">
                                            {errors.tags}
                                        </div>
                                    )}
                                </div>

                                {/* Order */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Display Order
                                    </label>
                                    <input
                                        type="number"
                                        value={data.order}
                                        onChange={(e) =>
                                            setData(
                                                "order",
                                                parseInt(e.target.value)
                                            )
                                        }
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                        min="0"
                                    />
                                    {errors.order && (
                                        <div className="text-red-600 text-sm mt-1">
                                            {errors.order}
                                        </div>
                                    )}
                                </div>

                                {/* Active Status */}
                                <div className="flex items-center">
                                    <input
                                        type="checkbox"
                                        checked={data.is_active}
                                        onChange={(e) =>
                                            setData(
                                                "is_active",
                                                e.target.checked
                                            )
                                        }
                                        className="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    />
                                    <label className="ml-2 block text-sm text-gray-900">
                                        Active
                                    </label>
                                </div>

                                {/* Submit Button */}
                                <div className="flex justify-end gap-3 pt-4">
                                    <Link
                                        href={route("admin.clients.index")}
                                        className="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
                                    >
                                        Cancel
                                    </Link>
                                    <button
                                        type="submit"
                                        disabled={processing}
                                        className="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50"
                                    >
                                        {processing
                                            ? "Updating..."
                                            : "Update Client"}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
