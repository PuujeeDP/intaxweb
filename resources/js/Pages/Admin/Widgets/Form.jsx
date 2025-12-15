import { useForm } from '@inertiajs/react';
import { useState } from 'react';
import AppLayout from '@/Layouts/AppLayout';
import TextInput from '@/Components/TextInput';
import TextArea from '@/Components/TextArea';
import EditorSwitcher from '@/Components/EditorSwitcher';

export default function Form({ widget, types, areas }) {
    const { data, setData, post, put, processing, errors } = useForm({
        key: widget?.key || '',
        name: widget?.name || '',
        type: widget?.type || 'html',
        content: widget?.content || {},
        area: widget?.area || 'sidebar',
        order: widget?.order || 0,
        is_active: widget?.is_active ?? true,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        if (widget) {
            put(`/admin/widgets/${widget.id}`);
        } else {
            post('/admin/widgets');
        }
    };

    const updateContent = (key, value) => {
        setData('content', {
            ...data.content,
            [key]: value,
        });
    };

    const renderContentFields = () => {
        switch (data.type) {
            case 'html':
                return (
                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">HTML Content</label>
                        <EditorSwitcher
                            value={data.content.html || ''}
                            onChange={(value) => updateContent('html', value)}
                            error={errors['content.html']}
                            height={400}
                        />
                    </div>
                );

            case 'text':
                return (
                    <div>
                        <TextArea
                            label="Text Content"
                            value={data.content.text || ''}
                            onChange={(e) => updateContent('text', e.target.value)}
                            error={errors['content.text']}
                            rows={6}
                        />
                    </div>
                );

            case 'cta':
                return (
                    <div className="space-y-4">
                        <TextInput
                            label="Title"
                            value={data.content.title || ''}
                            onChange={(e) => updateContent('title', e.target.value)}
                            error={errors['content.title']}
                        />
                        <TextArea
                            label="Description"
                            value={data.content.description || ''}
                            onChange={(e) => updateContent('description', e.target.value)}
                            error={errors['content.description']}
                            rows={3}
                        />
                        <TextInput
                            label="Button Text"
                            value={data.content.button_text || ''}
                            onChange={(e) => updateContent('button_text', e.target.value)}
                            error={errors['content.button_text']}
                        />
                        <TextInput
                            label="Button URL"
                            value={data.content.button_url || ''}
                            onChange={(e) => updateContent('button_url', e.target.value)}
                            error={errors['content.button_url']}
                        />
                    </div>
                );

            case 'stats':
                return (
                    <div className="space-y-4">
                        <p className="text-sm text-gray-600">Add up to 4 statistics</p>
                        {[1, 2, 3, 4].map((num) => (
                            <div key={num} className="border p-4 rounded">
                                <h4 className="font-medium mb-2">Stat {num}</h4>
                                <div className="grid grid-cols-2 gap-4">
                                    <TextInput
                                        label="Number"
                                        value={data.content[`stat${num}_number`] || ''}
                                        onChange={(e) => updateContent(`stat${num}_number`, e.target.value)}
                                    />
                                    <TextInput
                                        label="Label"
                                        value={data.content[`stat${num}_label`] || ''}
                                        onChange={(e) => updateContent(`stat${num}_label`, e.target.value)}
                                    />
                                </div>
                            </div>
                        ))}
                    </div>
                );

            case 'contact':
                return (
                    <div className="space-y-4">
                        <TextInput
                            label="Email"
                            value={data.content.email || ''}
                            onChange={(e) => updateContent('email', e.target.value)}
                        />
                        <TextInput
                            label="Phone"
                            value={data.content.phone || ''}
                            onChange={(e) => updateContent('phone', e.target.value)}
                        />
                        <TextArea
                            label="Address"
                            value={data.content.address || ''}
                            onChange={(e) => updateContent('address', e.target.value)}
                            rows={3}
                        />
                    </div>
                );

            case 'social':
                return (
                    <div className="space-y-4">
                        <TextInput
                            label="Facebook URL"
                            value={data.content.facebook || ''}
                            onChange={(e) => updateContent('facebook', e.target.value)}
                        />
                        <TextInput
                            label="Twitter URL"
                            value={data.content.twitter || ''}
                            onChange={(e) => updateContent('twitter', e.target.value)}
                        />
                        <TextInput
                            label="Instagram URL"
                            value={data.content.instagram || ''}
                            onChange={(e) => updateContent('instagram', e.target.value)}
                        />
                        <TextInput
                            label="LinkedIn URL"
                            value={data.content.linkedin || ''}
                            onChange={(e) => updateContent('linkedin', e.target.value)}
                        />
                    </div>
                );

            default:
                return null;
        }
    };

    return (
        <AppLayout title={widget ? 'Edit Widget' : 'Create Widget'}>
            <div className="py-12">
                <div className="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 border-b border-gray-200">
                            <h2 className="text-2xl font-bold">{widget ? 'Edit Widget' : 'Create Widget'}</h2>
                        </div>

                        <form onSubmit={handleSubmit} className="p-6 space-y-6">
                            {/* Basic Info */}
                            <div className="grid grid-cols-2 gap-4">
                                <TextInput
                                    label="Widget Key (Unique Identifier)"
                                    value={data.key}
                                    onChange={(e) => setData('key', e.target.value)}
                                    error={errors.key}
                                    required
                                    placeholder="e.g., contact-sidebar, footer-cta"
                                />
                                <TextInput
                                    label="Widget Name"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    error={errors.name}
                                    required
                                />
                            </div>

                            <div className="grid grid-cols-3 gap-4">
                                <div>
                                    <label htmlFor="type" className="block text-sm font-medium text-gray-700 mb-1">
                                        Widget Type *
                                    </label>
                                    <select
                                        id="type"
                                        value={data.type}
                                        onChange={(e) => setData('type', e.target.value)}
                                        className="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                    >
                                        {Object.entries(types).map(([value, label]) => (
                                            <option key={value} value={value}>{label}</option>
                                        ))}
                                    </select>
                                    {errors.type && <p className="mt-1 text-sm text-red-600">{errors.type}</p>}
                                </div>

                                <div>
                                    <label htmlFor="area" className="block text-sm font-medium text-gray-700 mb-1">
                                        Widget Area *
                                    </label>
                                    <select
                                        id="area"
                                        value={data.area}
                                        onChange={(e) => setData('area', e.target.value)}
                                        className="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                    >
                                        {Object.entries(areas).map(([value, label]) => (
                                            <option key={value} value={value}>{label}</option>
                                        ))}
                                    </select>
                                    {errors.area && <p className="mt-1 text-sm text-red-600">{errors.area}</p>}
                                </div>

                                <TextInput
                                    label="Display Order"
                                    type="number"
                                    value={data.order}
                                    onChange={(e) => setData('order', parseInt(e.target.value) || 0)}
                                    error={errors.order}
                                />
                            </div>

                            {/* Active Status */}
                            <div>
                                <label className="flex items-center space-x-2">
                                    <input
                                        type="checkbox"
                                        checked={data.is_active}
                                        onChange={(e) => setData('is_active', e.target.checked)}
                                        className="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                    />
                                    <span className="text-sm font-medium text-gray-700">Active</span>
                                </label>
                            </div>

                            {/* Content Fields (Dynamic based on type) */}
                            <div className="border-t pt-6">
                                <h3 className="text-lg font-semibold mb-4">Widget Content</h3>
                                {renderContentFields()}
                            </div>

                            {/* Submit Buttons */}
                            <div className="flex justify-end space-x-4 pt-6 border-t">
                                <a
                                    href="/admin/widgets"
                                    className="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
                                >
                                    Cancel
                                </a>
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50"
                                >
                                    {processing ? 'Saving...' : widget ? 'Update Widget' : 'Create Widget'}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
