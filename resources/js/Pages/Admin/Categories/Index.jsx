import AppLayout from '../../../Layouts/AppLayout';
import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';

export default function CategoriesIndex({ categories, filters }) {
    const [search, setSearch] = useState(filters.search || '');
    const [isActive, setIsActive] = useState(filters.is_active || '');

    const handleFilter = () => {
        router.get('/admin/categories', {
            search,
            is_active: isActive,
        }, {
            preserveState: true,
            replace: true,
        });
    };

    const handleDelete = (id) => {
        if (confirm('Are you sure you want to delete this category?')) {
            router.delete(`/admin/categories/${id}`);
        }
    };

    const renderCategoryTree = (category, level = 0) => {
        return (
            <>
                <tr key={category.id} className="hover:bg-gray-50">
                    <td className="px-6 py-4">
                        <div className="flex items-center" style={{ paddingLeft: `${level * 20}px` }}>
                            {level > 0 && <span className="mr-2 text-gray-400">└─</span>}
                            <div>
                                <div className="text-sm font-medium text-gray-900">{category.name}</div>
                                <div className="text-sm text-gray-500">{category.slug}</div>
                            </div>
                        </div>
                    </td>
                    <td className="px-6 py-4 text-sm text-gray-500">
                        {category.description ? category.description.substring(0, 50) + '...' : '-'}
                    </td>
                    <td className="px-6 py-4 text-sm text-gray-500">
                        {category.posts_count > 0 ? (
                            <span className="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {category.posts_count} {category.posts_count === 1 ? 'post' : 'posts'}
                            </span>
                        ) : (
                            <span className="text-gray-400">No posts</span>
                        )}
                    </td>
                    <td className="px-6 py-4">
                        <span className={`px-2 py-1 text-xs font-semibold rounded-full ${
                            category.is_active
                                ? 'bg-green-100 text-green-800'
                                : 'bg-gray-100 text-gray-800'
                        }`}>
                            {category.is_active ? 'Active' : 'Inactive'}
                        </span>
                    </td>
                    <td className="px-6 py-4 text-sm text-gray-500">
                        {category.order}
                    </td>
                    <td className="px-6 py-4 text-right text-sm font-medium space-x-2">
                        <Link
                            href={`/admin/categories/${category.id}/edit`}
                            className="text-blue-600 hover:text-blue-900"
                        >
                            Edit
                        </Link>
                        <button
                            onClick={() => handleDelete(category.id)}
                            className="text-red-600 hover:text-red-900"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
                {category.children && category.children.map(child => (
                    renderCategoryTree(child, level + 1)
                ))}
            </>
        );
    };

    const topLevelCategories = categories.filter(cat => !cat.parent_id);

    return (
        <AppLayout>
            <Head title="Categories" />

            <div className="mb-6 flex justify-between items-center">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Categories</h1>
                    <p className="mt-2 text-gray-600">Organize your content with multi-language categories</p>
                </div>
                <Link
                    href="/admin/categories/create"
                    className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                >
                    + New Category
                </Link>
            </div>

            {/* Filters */}
            <div className="bg-white rounded-lg shadow-md p-4 mb-6">
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input
                        type="text"
                        placeholder="Search categories..."
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                        className="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />

                    <select
                        value={isActive}
                        onChange={(e) => setIsActive(e.target.value)}
                        className="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>

                    <button
                        onClick={handleFilter}
                        className="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors"
                    >
                        Filter
                    </button>
                </div>
            </div>

            {/* Categories Table */}
            <div className="bg-white rounded-lg shadow-md overflow-hidden">
                <table className="min-w-full divide-y divide-gray-200">
                    <thead className="bg-gray-50">
                        <tr>
                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description
                            </th>
                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Posts
                            </th>
                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order
                            </th>
                            <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody className="bg-white divide-y divide-gray-200">
                        {categories.length === 0 ? (
                            <tr>
                                <td colSpan="6" className="px-6 py-12 text-center text-gray-500">
                                    No categories found. Create your first category!
                                </td>
                            </tr>
                        ) : (
                            topLevelCategories.map(category => (
                                renderCategoryTree(category)
                            ))
                        )}
                    </tbody>
                </table>
            </div>
        </AppLayout>
    );
}
