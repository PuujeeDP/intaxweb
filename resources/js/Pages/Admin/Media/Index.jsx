import AppLayout from '../../../Layouts/AppLayout';
import { Head, router, useForm } from '@inertiajs/react';
import { useState } from 'react';

export default function MediaIndex({ media, filters }) {
    const [search, setSearch] = useState(filters.search || '');
    const [type, setType] = useState(filters.type || '');
    const [showUpload, setShowUpload] = useState(false);
    const [selectedMedia, setSelectedMedia] = useState(null);

    const { data, setData, post, processing, reset } = useForm({
        file: null,
    });

    const handleFilter = () => {
        router.get('/admin/media', {
            search,
            type,
        }, {
            preserveState: true,
            replace: true,
        });
    };

    const handleUpload = (e) => {
        e.preventDefault();
        post('/admin/media', {
            onSuccess: () => {
                reset();
                setShowUpload(false);
            },
        });
    };

    const handleDelete = (id) => {
        if (confirm('Are you sure you want to delete this file?')) {
            router.delete(`/admin/media/${id}`);
        }
    };

    const getFileIcon = (mimeType) => {
        if (mimeType.startsWith('image/')) return '🖼️';
        if (mimeType.startsWith('video/')) return '🎥';
        if (mimeType.startsWith('audio/')) return '🎵';
        if (mimeType.includes('pdf')) return '📄';
        return '📁';
    };

    const isImage = (mimeType) => mimeType.startsWith('image/');

    return (
        <AppLayout>
            <Head title="Media Library" />

            <div className="mb-6 flex justify-between items-center">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Media Library</h1>
                    <p className="mt-2 text-gray-600">Manage your files and images</p>
                </div>
                <button
                    onClick={() => setShowUpload(true)}
                    className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                >
                    + Upload File
                </button>
            </div>

            {/* Upload Modal */}
            {showUpload && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div className="bg-white rounded-lg p-6 w-full max-w-md">
                        <div className="flex justify-between items-center mb-4">
                            <h2 className="text-xl font-bold">Upload File</h2>
                            <button
                                onClick={() => setShowUpload(false)}
                                className="text-gray-500 hover:text-gray-700"
                            >
                                ✕
                            </button>
                        </div>

                        <form onSubmit={handleUpload}>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Select File
                                </label>
                                <input
                                    type="file"
                                    onChange={(e) => setData('file', e.target.files[0])}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required
                                />
                                <p className="mt-1 text-sm text-gray-500">Max size: 10MB</p>
                            </div>

                            <div className="flex gap-2">
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50"
                                >
                                    {processing ? 'Uploading...' : 'Upload'}
                                </button>
                                <button
                                    type="button"
                                    onClick={() => setShowUpload(false)}
                                    className="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300"
                                >
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {/* Filters */}
            <div className="bg-white rounded-lg shadow-md p-4 mb-6">
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input
                        type="text"
                        placeholder="Search files..."
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                        className="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />

                    <select
                        value={type}
                        onChange={(e) => setType(e.target.value)}
                        className="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">All Types</option>
                        <option value="image">Images</option>
                        <option value="video">Videos</option>
                        <option value="audio">Audio</option>
                        <option value="application">Documents</option>
                    </select>

                    <button
                        onClick={handleFilter}
                        className="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors"
                    >
                        Filter
                    </button>
                </div>
            </div>

            {/* Media Grid */}
            <div className="bg-white rounded-lg shadow-md p-6">
                {media.data.length === 0 ? (
                    <div className="text-center py-12 text-gray-500">
                        <div className="text-6xl mb-4">📁</div>
                        <p>No files found. Upload your first file!</p>
                    </div>
                ) : (
                    <>
                        <div className="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            {media.data.map((item) => (
                                <div
                                    key={item.id}
                                    className="group relative bg-gray-50 rounded-lg overflow-hidden hover:shadow-lg transition-shadow cursor-pointer"
                                    onClick={() => setSelectedMedia(item)}
                                >
                                    <div className="aspect-square flex items-center justify-center bg-gray-100">
                                        {isImage(item.mime_type) ? (
                                            <img
                                                src={`/storage/${item.path}`}
                                                alt={item.name}
                                                className="w-full h-full object-cover"
                                            />
                                        ) : (
                                            <span className="text-4xl">{getFileIcon(item.mime_type)}</span>
                                        )}
                                    </div>
                                    <div className="p-2">
                                        <p className="text-xs font-medium text-gray-900 truncate">{item.name}</p>
                                        <p className="text-xs text-gray-500">{item.formatted_size}</p>
                                    </div>
                                    <div className="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button
                                            onClick={(e) => {
                                                e.stopPropagation();
                                                handleDelete(item.id);
                                            }}
                                            className="p-1 bg-red-600 text-white rounded hover:bg-red-700"
                                        >
                                            🗑️
                                        </button>
                                    </div>
                                </div>
                            ))}
                        </div>

                        {/* Pagination */}
                        {media.links.length > 3 && (
                            <div className="mt-6 flex justify-between items-center">
                                <div className="text-sm text-gray-700">
                                    Showing {media.from} to {media.to} of {media.total} files
                                </div>
                                <div className="flex space-x-2">
                                    {media.links.map((link, index) => (
                                        <button
                                            key={index}
                                            onClick={() => link.url && router.get(link.url)}
                                            disabled={!link.url}
                                            className={`px-3 py-1 rounded ${
                                                link.active
                                                    ? 'bg-blue-600 text-white'
                                                    : link.url
                                                    ? 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50'
                                                    : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                                            }`}
                                            dangerouslySetInnerHTML={{ __html: link.label }}
                                        />
                                    ))}
                                </div>
                            </div>
                        )}
                    </>
                )}
            </div>

            {/* Media Details Modal */}
            {selectedMedia && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div className="bg-white rounded-lg p-6 w-full max-w-2xl">
                        <div className="flex justify-between items-center mb-4">
                            <h2 className="text-xl font-bold">File Details</h2>
                            <button
                                onClick={() => setSelectedMedia(null)}
                                className="text-gray-500 hover:text-gray-700"
                            >
                                ✕
                            </button>
                        </div>

                        <div className="space-y-4">
                            {isImage(selectedMedia.mime_type) && (
                                <img
                                    src={`/storage/${selectedMedia.path}`}
                                    alt={selectedMedia.name}
                                    className="w-full rounded-lg"
                                />
                            )}

                            <div className="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <strong>Name:</strong> {selectedMedia.name}
                                </div>
                                <div>
                                    <strong>Size:</strong> {selectedMedia.formatted_size}
                                </div>
                                <div>
                                    <strong>Type:</strong> {selectedMedia.mime_type}
                                </div>
                                <div>
                                    <strong>Uploaded:</strong> {new Date(selectedMedia.created_at).toLocaleDateString()}
                                </div>
                                <div className="col-span-2">
                                    <strong>URL:</strong>
                                    <input
                                        type="text"
                                        value={`/storage/${selectedMedia.path}`}
                                        readOnly
                                        className="w-full mt-1 px-2 py-1 border rounded text-xs"
                                    />
                                </div>
                            </div>

                            <button
                                onClick={() => setSelectedMedia(null)}
                                className="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </AppLayout>
    );
}
