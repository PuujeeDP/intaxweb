import { useState, useEffect } from 'react';
import { router } from '@inertiajs/react';
import MenuItemForm from './MenuItemForm';
import MenuItemList from './MenuItemList';

export default function MenuBuilder({ menu, availableContent }) {
    const [items, setItems] = useState([]);
    const [showForm, setShowForm] = useState(false);
    const [editingItem, setEditingItem] = useState(null);
    const [saving, setSaving] = useState(false);

    // Initialize items from menu
    useEffect(() => {
        if (menu.items) {
            // Items are already flat from backend, just format them
            const formattedItems = menu.items.map((item) => {
                const formattedItem = {
                    id: item.id,
                    parent_id: item.parent_id || null,
                    type: item.type,
                    linkable_id: item.linkable_id,
                    linkable_type: item.linkable_type,
                    url: item.url,
                    title: {
                        en: '',
                        mn: '',
                        zh: '',
                    },
                    target: item.target || '_self',
                    icon: item.icon || '',
                    css_class: item.css_class || '',
                    navigation_menu_slug: item.navigation_menu_slug || '',
                    order: item.order || 0,
                    is_active: item.is_active ?? true,
                };

                // Extract titles from translations
                if (item.translations) {
                    item.translations.forEach((translation) => {
                        if (translation.field === 'title') {
                            formattedItem.title[translation.locale] = translation.value;
                        }
                    });
                }

                return formattedItem;
            });

            setItems(formattedItems);
        }
    }, [menu.items]);

    // Add new item
    const handleAddItem = (itemData) => {
        const newItem = {
            id: `temp-${Date.now()}`,
            ...itemData,
            order: items.length,
        };
        setItems([...items, newItem]);
        setShowForm(false);
    };

    // Update item
    const handleUpdateItem = (itemData) => {
        setItems(items.map((item) => (item.id === editingItem.id ? { ...item, ...itemData } : item)));
        setEditingItem(null);
        setShowForm(false);
    };

    // Delete item
    const handleDeleteItem = (itemId) => {
        if (confirm('Are you sure you want to delete this menu item?')) {
            setItems(items.filter((item) => item.id !== itemId && item.parent_id !== itemId));
        }
    };

    // Reorder items (called after drag and drop)
    const handleReorder = (newItems) => {
        setItems(newItems);
    };

    // Save all items to server
    const handleSave = () => {
        setSaving(true);

        router.post(
            `/admin/menus/${menu.id}/items`,
            { items },
            {
                onSuccess: () => {
                    setSaving(false);
                    alert('Menu items saved successfully!');
                },
                onError: (errors) => {
                    setSaving(false);
                    console.error('Save errors:', errors);
                    alert('Failed to save menu items. Please check the console for errors.');
                },
            }
        );
    };

    return (
        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 border-b border-gray-200 flex justify-between items-center">
                <h2 className="text-2xl font-bold">Menu Items</h2>
                <div className="space-x-2">
                    <button
                        onClick={() => {
                            setEditingItem(null);
                            setShowForm(!showForm);
                        }}
                        className="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded"
                    >
                        {showForm ? 'Cancel' : 'Add Item'}
                    </button>
                    <button
                        onClick={handleSave}
                        disabled={saving}
                        className="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded disabled:opacity-50"
                    >
                        {saving ? 'Saving...' : 'Save Menu'}
                    </button>
                </div>
            </div>

            <div className="p-6">
                {/* Add/Edit Form */}
                {showForm && (
                    <div className="mb-6 p-4 border-2 border-blue-200 rounded-lg bg-blue-50">
                        <h3 className="text-lg font-semibold mb-4">
                            {editingItem ? 'Edit Menu Item' : 'Add New Menu Item'}
                        </h3>
                        <MenuItemForm
                            initialData={editingItem}
                            availableContent={availableContent}
                            onSubmit={editingItem ? handleUpdateItem : handleAddItem}
                            onCancel={() => {
                                setShowForm(false);
                                setEditingItem(null);
                            }}
                        />
                    </div>
                )}

                {/* Menu Items List */}
                {items.length === 0 ? (
                    <div className="text-center py-12 text-gray-500">
                        <p>No menu items yet. Click "Add Item" to create your first menu item.</p>
                    </div>
                ) : (
                    <MenuItemList
                        items={items}
                        onReorder={handleReorder}
                        onEdit={(item) => {
                            setEditingItem(item);
                            setShowForm(true);
                        }}
                        onDelete={handleDeleteItem}
                    />
                )}
            </div>
        </div>
    );
}
