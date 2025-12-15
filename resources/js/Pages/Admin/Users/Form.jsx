import AppLayout from '../../../Layouts/AppLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import TextInput from '../../../Components/TextInput';

export default function UserForm({ user, roles, userRoleIds }) {
    const isEditing = !!user;

    const { data, setData, post: submit, put, processing, errors } = useForm({
        name: user?.name || '',
        email: user?.email || '',
        password: '',
        password_confirmation: '',
        role_ids: userRoleIds || [],
    });

    const handleSubmit = (e) => {
        e.preventDefault();

        if (isEditing) {
            put(`/admin/users/${user.id}`);
        } else {
            submit('/admin/users');
        }
    };

    const toggleRole = (roleId) => {
        if (data.role_ids.includes(roleId)) {
            setData('role_ids', data.role_ids.filter(id => id !== roleId));
        } else {
            setData('role_ids', [...data.role_ids, roleId]);
        }
    };

    return (
        <AppLayout>
            <Head title={isEditing ? 'Edit User' : 'Create User'} />

            <div className="mb-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">
                            {isEditing ? 'Edit User' : 'Create New User'}
                        </h1>
                        <p className="mt-2 text-gray-600">Manage user account and permissions</p>
                    </div>
                    <Link
                        href="/admin/users"
                        className="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300"
                    >
                        ← Back
                    </Link>
                </div>
            </div>

            <form onSubmit={handleSubmit}>
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Main Content */}
                    <div className="lg:col-span-2">
                        <div className="bg-white rounded-lg shadow-md p-6 space-y-4">
                            <h2 className="text-lg font-semibold mb-4">User Information</h2>

                            <TextInput
                                label="Name *"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                error={errors.name}
                                placeholder="Enter user's full name"
                            />

                            <TextInput
                                label="Email *"
                                type="email"
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                error={errors.email}
                                placeholder="user@example.com"
                            />

                            <div className="border-t pt-4 mt-6">
                                <h3 className="text-md font-semibold mb-3">
                                    {isEditing ? 'Change Password (leave blank to keep current)' : 'Password *'}
                                </h3>

                                <div className="space-y-4">
                                    <TextInput
                                        label={isEditing ? "New Password" : "Password *"}
                                        type="password"
                                        value={data.password}
                                        onChange={(e) => setData('password', e.target.value)}
                                        error={errors.password}
                                        placeholder="Minimum 8 characters"
                                    />

                                    <TextInput
                                        label="Confirm Password"
                                        type="password"
                                        value={data.password_confirmation}
                                        onChange={(e) => setData('password_confirmation', e.target.value)}
                                        placeholder="Re-enter password"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Sidebar */}
                    <div className="space-y-6">
                        {/* Roles */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h2 className="text-lg font-semibold mb-4">Roles *</h2>

                            <div className="space-y-2">
                                {roles.map((role) => (
                                    <label
                                        key={role.id}
                                        className="flex items-start p-3 border rounded-lg hover:bg-gray-50 cursor-pointer"
                                    >
                                        <input
                                            type="checkbox"
                                            checked={data.role_ids.includes(role.id)}
                                            onChange={() => toggleRole(role.id)}
                                            className="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                        />
                                        <div className="ml-3">
                                            <div className="text-sm font-medium text-gray-900">
                                                {role.name}
                                            </div>
                                            {role.description && (
                                                <div className="text-xs text-gray-500 mt-1">
                                                    {role.description}
                                                </div>
                                            )}
                                        </div>
                                    </label>
                                ))}
                            </div>

                            {errors.role_ids && (
                                <p className="mt-2 text-sm text-red-600">{errors.role_ids}</p>
                            )}
                        </div>

                        {/* Actions */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <button
                                type="submit"
                                disabled={processing}
                                className="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                            >
                                {processing ? 'Saving...' : (isEditing ? 'Update User' : 'Create User')}
                            </button>

                            {isEditing && (
                                <Link
                                    href="/admin/users"
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
