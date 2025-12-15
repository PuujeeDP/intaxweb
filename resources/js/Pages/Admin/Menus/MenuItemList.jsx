import { useState } from 'react';

export default function MenuItemList({ items, onReorder, onEdit, onDelete }) {
    const [draggedItem, setDraggedItem] = useState(null);
    const [dragOverItem, setDragOverItem] = useState(null);
    const [dropZone, setDropZone] = useState(null); // 'before', 'after', 'inside'

    // Get root items (no parent)
    const rootItems = items.filter((item) => !item.parent_id);

    // Get children of a parent
    const getChildren = (parentId) => {
        return items.filter((item) => item.parent_id === parentId);
    };

    // Handle drag start
    const handleDragStart = (e, item) => {
        setDraggedItem(item);
        e.dataTransfer.effectAllowed = 'move';
    };

    // Handle drag over - detect drop zone
    const handleDragOver = (e, item) => {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';

        const rect = e.currentTarget.getBoundingClientRect();
        const y = e.clientY - rect.top;
        const height = rect.height;

        // Determine drop zone based on mouse position
        if (y < height * 0.25) {
            setDropZone('before');
        } else if (y > height * 0.75) {
            setDropZone('after');
        } else {
            setDropZone('inside');
        }

        setDragOverItem(item);
    };

    // Handle drag leave
    const handleDragLeave = () => {
        setDropZone(null);
    };

    // Handle drop
    const handleDrop = (e, targetItem) => {
        e.preventDefault();

        if (!draggedItem || draggedItem.id === targetItem.id) {
            setDraggedItem(null);
            setDragOverItem(null);
            setDropZone(null);
            return;
        }

        // Prevent dropping parent into its own child
        if (isDescendant(draggedItem.id, targetItem.id)) {
            alert('Cannot drop a parent item into its own child!');
            setDraggedItem(null);
            setDragOverItem(null);
            setDropZone(null);
            return;
        }

        const updatedItems = [...items];
        const draggedIndex = updatedItems.findIndex((item) => item.id === draggedItem.id);
        const targetIndex = updatedItems.findIndex((item) => item.id === targetItem.id);

        // Remove dragged item
        const [removed] = updatedItems.splice(draggedIndex, 1);

        if (dropZone === 'inside') {
            // Make it a child of target
            removed.parent_id = targetItem.id;
            updatedItems.splice(targetIndex + 1, 0, removed);
        } else if (dropZone === 'before') {
            // Insert before target, same parent level
            removed.parent_id = targetItem.parent_id;
            const newTargetIndex = updatedItems.findIndex((item) => item.id === targetItem.id);
            updatedItems.splice(newTargetIndex, 0, removed);
        } else if (dropZone === 'after') {
            // Insert after target, same parent level
            removed.parent_id = targetItem.parent_id;
            const newTargetIndex = updatedItems.findIndex((item) => item.id === targetItem.id);
            updatedItems.splice(newTargetIndex + 1, 0, removed);
        }

        // Update order numbers
        const reorderedItems = updatedItems.map((item, index) => ({
            ...item,
            order: index,
        }));

        onReorder(reorderedItems);
        setDraggedItem(null);
        setDragOverItem(null);
        setDropZone(null);
    };

    // Check if itemId is a descendant of parentId
    const isDescendant = (parentId, itemId) => {
        let current = items.find(item => item.id === itemId);
        while (current && current.parent_id) {
            if (current.parent_id === parentId) return true;
            current = items.find(item => item.id === current.parent_id);
        }
        return false;
    };

    // Render single menu item
    const renderItem = (item, depth = 0) => {
        const children = getChildren(item.id);
        const isDragging = draggedItem?.id === item.id;
        const isDragOver = dragOverItem?.id === item.id;

        return (
            <div key={item.id} className={`${depth > 0 ? 'ml-8' : ''}`}>
                <div className="relative">
                    {/* Drop zone indicators */}
                    {isDragOver && dropZone === 'before' && (
                        <div className="absolute -top-1 left-0 right-0 h-1 bg-green-500 rounded z-10"></div>
                    )}
                    {isDragOver && dropZone === 'after' && (
                        <div className="absolute -bottom-1 left-0 right-0 h-1 bg-green-500 rounded z-10"></div>
                    )}

                    <div
                        draggable
                        onDragStart={(e) => handleDragStart(e, item)}
                        onDragOver={(e) => handleDragOver(e, item)}
                        onDragLeave={handleDragLeave}
                        onDrop={(e) => handleDrop(e, item)}
                        className={`
                            flex items-center justify-between p-4 mb-2 border rounded-lg cursor-move
                            transition-all duration-200 relative
                            ${isDragging ? 'opacity-50 border-blue-500 bg-blue-50' : 'bg-white'}
                            ${isDragOver && dropZone === 'inside' ? 'border-green-500 border-2 bg-green-50' : 'border-gray-300'}
                            ${isDragOver && dropZone !== 'inside' ? 'border-green-500' : ''}
                            hover:border-blue-400 hover:shadow-md
                        `}
                    >
                    <div className="flex items-center space-x-4 flex-1">
                        {/* Drag Handle */}
                        <div className="text-gray-400 cursor-move">
                            <svg
                                className="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                            </svg>
                        </div>

                        {/* Icon */}
                        {item.icon && <span className="text-xl">{item.icon}</span>}

                        {/* Content */}
                        <div className="flex-1">
                            <div className="font-medium text-gray-900">
                                {item.title.en || item.title.mn || item.title.zh || 'Untitled'}
                            </div>
                            <div className="text-sm text-gray-500 space-x-2">
                                <span className="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100">
                                    {item.type}
                                </span>
                                {item.url && (
                                    <span className="text-blue-600">{item.url}</span>
                                )}
                                {!item.is_active && (
                                    <span className="text-red-600">(Inactive)</span>
                                )}
                            </div>
                        </div>

                        {/* Target Badge */}
                        {item.target === '_blank' && (
                            <span className="text-xs text-gray-500">↗</span>
                        )}
                    </div>

                    {/* Actions */}
                    <div className="flex items-center space-x-2 ml-4">
                        <button
                            onClick={() => onEdit(item)}
                            className="px-3 py-1 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded"
                        >
                            Edit
                        </button>
                        <button
                            onClick={() => onDelete(item.id)}
                            className="px-3 py-1 text-sm text-red-600 hover:text-red-800 hover:bg-red-50 rounded"
                        >
                            Delete
                        </button>
                    </div>
                    </div>
                </div>

                {/* Render children recursively */}
                {children.length > 0 && (
                    <div className="ml-4">
                        {children.map((child) => renderItem(child, depth + 1))}
                    </div>
                )}
            </div>
        );
    };

    return (
        <div className="space-y-2">
            {rootItems.length === 0 ? (
                <div className="text-center py-12 text-gray-500">
                    <p>No menu items yet.</p>
                </div>
            ) : (
                rootItems.map((item) => renderItem(item))
            )}

            {/* Drag and Drop Instructions */}
            {rootItems.length > 0 && (
                <div className="mt-4 p-4 bg-blue-50 border border-blue-200 rounded text-sm text-blue-700">
                    <strong>💡 Drag & Drop Tips:</strong>
                    <ul className="mt-2 space-y-1 list-disc list-inside">
                        <li><strong>Top 25%</strong> of item: Insert <strong>before</strong> (green line above)</li>
                        <li><strong>Middle 50%</strong> of item: Make it a <strong>submenu</strong> (green background)</li>
                        <li><strong>Bottom 25%</strong> of item: Insert <strong>after</strong> (green line below)</li>
                    </ul>
                </div>
            )}
        </div>
    );
}
