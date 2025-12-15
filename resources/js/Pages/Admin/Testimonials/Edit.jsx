import { useState } from "react";
import { Head, Link, useForm } from "@inertiajs/react";
import AppLayout from "@/Layouts/AppLayout";

export default function Edit({ testimonial }) {
    const { data, setData, put, processing, errors } = useForm({
        client_name: testimonial.client_name || "",
        client_position: testimonial.client_position || "",
        client_company: testimonial.client_company || "",
        client_photo_id: testimonial.client_photo_id || null,
        content: testimonial.content || "",
        rating: testimonial.rating || 5,
        order: testimonial.order || 0,
        is_active: testimonial.is_active ?? true,
    });

    const [uploading, setUploading] = useState(false);
    const [previewImage, setPreviewImage] = useState(
        testimonial?.client_photo?.file_path || null
    );

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route("admin.testimonials.update", testimonial.id));
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
                setData("client_photo_id", result.media.id);
                setPreviewImage(result.media.file_path);
            } else {
                alert("Failed to upload photo");
            }
        } catch (error) {
            console.error("Upload error:", error);
            alert("Failed to upload photo");
        } finally {
            setUploading(false);
        }
    };

    const removeImage = () => {
        setData("client_photo_id", null);
        setPreviewImage(null);
    };

    const renderStars = () => {
        return [...Array(5)].map((_, index) => {
            const starValue = index + 1;
            return (
                <button
                    key={index}
                    type="button"
                    onClick={() => setData("rating", starValue)}
                    className={`text-3xl ${starValue <= data.rating ? 'text-yellow-400' : 'text-gray-300'} hover:text-yellow-400 transition`}
                >
                    ★
                </button>
            );
        });
    };

    return (
        <AppLayout>
            <Head title={`Edit Testimonial: ${testimonial.client_name}`} />

            <div className="py-12">
                <div className="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            <div className="flex justify-between items-center mb-6">
                                <h2 className="text-2xl font-bold text-gray-800">
                                    Edit Testimonial
                                </h2>
                                <Link
                                    href={route("admin.testimonials.index")}
                                    className="text-gray-600 hover:text-gray-900"
                                >
                                    Back to List
                                </Link>
                            </div>

                            <form onSubmit={handleSubmit} className="space-y-6">
                                {/* Client Name */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Client Name *
                                    </label>
                                    <input
                                        type="text"
                                        value={data.client_name}
                                        onChange={(e) =>
                                            setData("client_name", e.target.value)
                                        }
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                        required
                                    />
                                    {errors.client_name && (
                                        <div className="text-red-600 text-sm mt-1">
                                            {errors.client_name}
                                        </div>
                                    )}
                                </div>

                                {/* Client Position */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Position / Title
                                    </label>
                                    <input
                                        type="text"
                                        value={data.client_position}
                                        onChange={(e) =>
                                            setData("client_position", e.target.value)
                                        }
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                        placeholder="e.g., CEO, Manager, etc."
                                    />
                                    {errors.client_position && (
                                        <div className="text-red-600 text-sm mt-1">
                                            {errors.client_position}
                                        </div>
                                    )}
                                </div>

                                {/* Client Company */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Company
                                    </label>
                                    <input
                                        type="text"
                                        value={data.client_company}
                                        onChange={(e) =>
                                            setData("client_company", e.target.value)
                                        }
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                        placeholder="Company name"
                                    />
                                    {errors.client_company && (
                                        <div className="text-red-600 text-sm mt-1">
                                            {errors.client_company}
                                        </div>
                                    )}
                                </div>

                                {/* Client Photo Upload */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Client Photo
                                    </label>
                                    {previewImage ? (
                                        <div className="mb-4">
                                            <img
                                                src={previewImage}
                                                alt="Preview"
                                                className="w-24 h-24 rounded-full object-cover border"
                                            />
                                            <button
                                                type="button"
                                                onClick={removeImage}
                                                className="mt-2 text-red-600 hover:text-red-800"
                                            >
                                                Remove Photo
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
                                    {errors.client_photo_id && (
                                        <div className="text-red-600 text-sm mt-1">
                                            {errors.client_photo_id}
                                        </div>
                                    )}
                                </div>

                                {/* Testimonial Content */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Testimonial Content *
                                    </label>
                                    <textarea
                                        value={data.content}
                                        onChange={(e) =>
                                            setData("content", e.target.value)
                                        }
                                        rows="6"
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                        placeholder="What did the client say about your service?"
                                        required
                                    />
                                    {errors.content && (
                                        <div className="text-red-600 text-sm mt-1">
                                            {errors.content}
                                        </div>
                                    )}
                                </div>

                                {/* Rating */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Rating *
                                    </label>
                                    <div className="flex gap-1">
                                        {renderStars()}
                                    </div>
                                    <p className="text-sm text-gray-500 mt-1">
                                        Click on stars to set rating (current: {data.rating}/5)
                                    </p>
                                    {errors.rating && (
                                        <div className="text-red-600 text-sm mt-1">
                                            {errors.rating}
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
                                        href={route("admin.testimonials.index")}
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
                                            : "Update Testimonial"}
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
