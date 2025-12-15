import { Head, router } from '@inertiajs/react';
import { useState } from 'react';
import AppLayout from '@/Layouts/AppLayout';
import MenuBuilder from './MenuBuilder';

export default function Edit({ menu, availableContent }) {
    const [menuData, setMenuData] = useState({
        name: menu.name,
        location: menu.location,
        description: menu.description || '',
        is_active: menu.is_active,
    });
    const [errors, setErrors] = useState({});
    const [processing, setProcessing] = useState(false);

    const handleUpdateMenu = (e) => {
        e.preventDefault();
        setProcessing(true);

        router.put(
            `/admin/menus/${menu.id}`,
            menuData,
            {
                onSuccess: () => {
                    setProcessing(false);
                },
                onError: (errors) => {
                    setErrors(errors);
                    setProcessing(false);
                },
            }
        );
    };

    return (
        <AppLayout>
            <Head title={`Edit Menu: ${menu.name}`} />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    {/* Menu Settings */}
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 border-b border-gray-200">
                            <h2 className="text-2xl font-bold">Menu Settings</h2>
                        </div>

                        <form onSubmit={handleUpdateMenu} className="p-6 space-y-6">
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {/* Name */}
                                <div>
                                    <label htmlFor="name" className="block text-sm font-medium text-gray-700">
                                        Menu Name
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        value={menuData.name}
                                        onChange={(e) => setMenuData({ ...menuData, name: e.target.value })}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    />
                                    {errors.name && (
                                        <p className="mt-1 text-sm text-red-600">{errors.name}</p>
                                    )}
                                </div>

                                {/* Location */}
                                <div>
                                    <label htmlFor="location" className="block text-sm font-medium text-gray-700">
                                        Location Identifier
                                    </label>
                                    <input
                                        type="text"
                                        id="location"
                                        value={menuData.location}
                                        onChange={(e) => setMenuData({ ...menuData, location: e.target.value })}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    />
                                    {errors.location && (
                                        <p className="mt-1 text-sm text-red-600">{errors.location}</p>
                                    )}
                                </div>
                            </div>

                            {/* Description */}
                            <div>
                                <label htmlFor="description" className="block text-sm font-medium text-gray-700">
                                    Description
                                </label>
                                <textarea
                                    id="description"
                                    value={menuData.description}
                                    onChange={(e) => setMenuData({ ...menuData, description: e.target.value })}
                                    rows="2"
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                />
                            </div>

                            {/* Is Active */}
                            <div className="flex items-center">
                                <input
                                    type="checkbox"
                                    id="is_active"
                                    checked={menuData.is_active}
                                    onChange={(e) => setMenuData({ ...menuData, is_active: e.target.checked })}
                                    className="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                />
                                <label htmlFor="is_active" className="ml-2 block text-sm text-gray-900">
                                    Active (visible on frontend)
                                </label>
                            </div>

                            {/* Submit Button */}
                            <div className="flex items-center justify-end space-x-3 pt-4 border-t">
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 disabled:opacity-50"
                                >
                                    {processing ? 'Updating...' : 'Update Menu Settings'}
                                </button>
                            </div>
                        </form>
                    </div>

                    {/* Menu Builder */}
                    <MenuBuilder menu={menu} availableContent={availableContent} />
                </div>
            </div>
        </AppLayout>
    );
}
