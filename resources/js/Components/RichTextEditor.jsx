import { useEffect, useState, useRef } from 'react';
import { useEditor, EditorContent } from '@tiptap/react';
import StarterKit from '@tiptap/starter-kit';
import { Link } from '@tiptap/extension-link';
import { Image } from '@tiptap/extension-image';
import { Table } from '@tiptap/extension-table';
import { TableRow } from '@tiptap/extension-table-row';
import { TableCell } from '@tiptap/extension-table-cell';
import { TableHeader } from '@tiptap/extension-table-header';
import { Color } from '@tiptap/extension-color';
import { TextStyle } from '@tiptap/extension-text-style';
import TextAlign from '@tiptap/extension-text-align';
import Underline from '@tiptap/extension-underline';
import Highlight from '@tiptap/extension-highlight';
import Youtube from '@tiptap/extension-youtube';
import '../../css/tiptap.css';

export default function RichTextEditor({ label, value, onChange, error, className = '', height = 500 }) {
    const [showHtml, setShowHtml] = useState(false);
    const [showColorPicker, setShowColorPicker] = useState(false);
    const [showHighlightPicker, setShowHighlightPicker] = useState(false);
    const [showImageUpload, setShowImageUpload] = useState(false);
    const [uploading, setUploading] = useState(false);
    const [showImageMenu, setShowImageMenu] = useState(false);
    const [imageMenuPosition, setImageMenuPosition] = useState({ top: 0, left: 0 });

    const editor = useEditor({
        extensions: [
            StarterKit.configure({
                // Disable the default link extension from StarterKit to avoid duplication
                link: false,
            }),
            TextStyle,
            Color,
            Underline,
            Highlight.configure({ multicolor: true }),
            TextAlign.configure({
                types: ['heading', 'paragraph'],
                alignments: ['left', 'center', 'right', 'justify'],
            }),
            Link.configure({
                openOnClick: false,
            }),
            Image.extend({
                addAttributes() {
                    return {
                        ...this.parent?.(),
                        width: {
                            default: null,
                            parseHTML: element => element.getAttribute('width'),
                            renderHTML: attributes => {
                                if (!attributes.width) return {};
                                return { width: attributes.width };
                            },
                        },
                        height: {
                            default: null,
                            parseHTML: element => element.getAttribute('height'),
                            renderHTML: attributes => {
                                if (!attributes.height) return {};
                                return { height: attributes.height };
                            },
                        },
                        style: {
                            default: null,
                            parseHTML: element => element.getAttribute('style'),
                            renderHTML: attributes => {
                                if (!attributes.style) return {};
                                return { style: attributes.style };
                            },
                        },
                    };
                },
            }).configure({
                inline: true,
                allowBase64: true,
            }),
            Youtube.configure({
                controls: true,
                nocookie: true,
                width: 640,
                height: 480,
            }),
            Table.configure({
                resizable: true,
            }),
            TableRow,
            TableCell,
            TableHeader,
        ],
        content: value || '',
        onUpdate: ({ editor }) => {
            if (onChange) {
                onChange(editor.getHTML());
            }
        },
    });

    // Update content when value prop changes from outside
    useEffect(() => {
        if (editor && value !== undefined) {
            const isSame = editor.getHTML() === value;
            if (!isSame && value !== null) {
                editor.commands.setContent(value, false);
            }
        }
    }, [editor, value]);

    // Handle image selection
    useEffect(() => {
        if (!editor) return;

        const handleClick = (event) => {
            const target = event.target;
            if (target.tagName === 'IMG') {
                event.preventDefault();
                const rect = target.getBoundingClientRect();
                const editorRect = editor.view.dom.getBoundingClientRect();

                // Select the image in editor
                const pos = editor.view.posAtDOM(target, 0);
                editor.chain().focus().setNodeSelection(pos).run();

                setImageMenuPosition({
                    top: rect.bottom + window.scrollY + 10,
                    left: rect.left + window.scrollX,
                });
                setShowImageMenu(true);
            } else if (!event.target.closest('.image-menu')) {
                setShowImageMenu(false);
            }
        };

        const editorElement = editor.view.dom;
        editorElement.addEventListener('click', handleClick);
        document.addEventListener('click', handleClick);

        return () => {
            editorElement.removeEventListener('click', handleClick);
            document.removeEventListener('click', handleClick);
        };
    }, [editor]);

    if (!editor) {
        return null;
    }

    const MenuButton = ({ onClick, isActive, children, title }) => (
        <button
            type="button"
            onClick={(e) => {
                e.preventDefault();
                onClick();
            }}
            onMouseDown={(e) => e.preventDefault()}
            title={title}
            className={`px-3 py-1.5 text-sm font-medium rounded transition-colors ${
                isActive
                    ? 'bg-gray-700 text-white'
                    : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-300'
            }`}
        >
            {children}
        </button>
    );

    return (
        <div className={className}>
            {label && (
                <label className="block text-sm font-medium text-gray-700 mb-2">
                    {label}
                </label>
            )}
            <div className={`border rounded-lg overflow-hidden ${error ? 'border-red-500' : 'border-gray-300'}`}>
                {/* Toolbar */}
                <div className="bg-gray-50 border-b border-gray-300 p-2 flex flex-wrap gap-1">
                    <MenuButton
                        onClick={() => editor.chain().focus().toggleBold().run()}
                        isActive={editor.isActive('bold')}
                        title="Bold"
                    >
                        <strong>B</strong>
                    </MenuButton>
                    <MenuButton
                        onClick={() => editor.chain().focus().toggleItalic().run()}
                        isActive={editor.isActive('italic')}
                        title="Italic"
                    >
                        <em>I</em>
                    </MenuButton>
                    <MenuButton
                        onClick={() => editor.chain().focus().toggleStrike().run()}
                        isActive={editor.isActive('strike')}
                        title="Strike"
                    >
                        <s>S</s>
                    </MenuButton>
                    <MenuButton
                        onClick={() => editor.chain().focus().toggleUnderline().run()}
                        isActive={editor.isActive('underline')}
                        title="Underline"
                    >
                        <u>U</u>
                    </MenuButton>

                    <div className="w-px bg-gray-300 mx-1" />

                    <MenuButton
                        onClick={() => editor.chain().focus().toggleHeading({ level: 1 }).run()}
                        isActive={editor.isActive('heading', { level: 1 })}
                        title="Heading 1"
                    >
                        H1
                    </MenuButton>
                    <MenuButton
                        onClick={() => editor.chain().focus().toggleHeading({ level: 2 }).run()}
                        isActive={editor.isActive('heading', { level: 2 })}
                        title="Heading 2"
                    >
                        H2
                    </MenuButton>
                    <MenuButton
                        onClick={() => editor.chain().focus().toggleHeading({ level: 3 }).run()}
                        isActive={editor.isActive('heading', { level: 3 })}
                        title="Heading 3"
                    >
                        H3
                    </MenuButton>

                    <div className="w-px bg-gray-300 mx-1" />

                    <MenuButton
                        onClick={() => {
                            console.log('Bullet list clicked');
                            editor.chain().focus().toggleBulletList().run();
                        }}
                        isActive={editor.isActive('bulletList')}
                        title="Bullet List"
                    >
                        • List
                    </MenuButton>
                    <MenuButton
                        onClick={() => {
                            console.log('Ordered list clicked');
                            editor.chain().focus().toggleOrderedList().run();
                        }}
                        isActive={editor.isActive('orderedList')}
                        title="Numbered List"
                    >
                        1. List
                    </MenuButton>

                    <div className="w-px bg-gray-300 mx-1" />

                    <MenuButton
                        onClick={() => {
                            console.log('Blockquote clicked');
                            editor.chain().focus().toggleBlockquote().run();
                        }}
                        isActive={editor.isActive('blockquote')}
                        title="Quote"
                    >
                        " Quote
                    </MenuButton>
                    <MenuButton
                        onClick={() => editor.chain().focus().toggleCodeBlock().run()}
                        isActive={editor.isActive('codeBlock')}
                        title="Code Block"
                    >
                        {'</>'}
                    </MenuButton>

                    <div className="w-px bg-gray-300 mx-1" />

                    {/* Text Alignment */}
                    <MenuButton
                        onClick={() => editor.chain().focus().setTextAlign('left').run()}
                        isActive={editor.isActive({ textAlign: 'left' })}
                        title="Align Left"
                    >
                        ⬅
                    </MenuButton>
                    <MenuButton
                        onClick={() => editor.chain().focus().setTextAlign('center').run()}
                        isActive={editor.isActive({ textAlign: 'center' })}
                        title="Align Center"
                    >
                        ↔
                    </MenuButton>
                    <MenuButton
                        onClick={() => editor.chain().focus().setTextAlign('right').run()}
                        isActive={editor.isActive({ textAlign: 'right' })}
                        title="Align Right"
                    >
                        ➡
                    </MenuButton>
                    <MenuButton
                        onClick={() => editor.chain().focus().setTextAlign('justify').run()}
                        isActive={editor.isActive({ textAlign: 'justify' })}
                        title="Justify"
                    >
                        ≡
                    </MenuButton>

                    <div className="w-px bg-gray-300 mx-1" />

                    {/* Highlight Color Picker */}
                    <div className="relative">
                        <MenuButton
                            onClick={() => setShowHighlightPicker(!showHighlightPicker)}
                            isActive={showHighlightPicker || editor.isActive('highlight')}
                            title="Highlight Text"
                        >
                            🖍 Highlight
                        </MenuButton>

                        {showHighlightPicker && (
                            <div
                                className="absolute top-full left-0 mt-1 bg-white border border-gray-300 rounded-lg shadow-lg p-2 z-50 grid grid-cols-5 gap-1"
                                style={{ width: 'max-content' }}
                            >
                                {[
                                    { name: 'Yellow', color: '#fef08a' },
                                    { name: 'Green', color: '#bbf7d0' },
                                    { name: 'Blue', color: '#bfdbfe' },
                                    { name: 'Pink', color: '#fbcfe8' },
                                    { name: 'Purple', color: '#e9d5ff' },
                                    { name: 'Orange', color: '#fed7aa' },
                                    { name: 'Red', color: '#fecaca' },
                                    { name: 'Gray', color: '#e5e7eb' },
                                ].map((item) => (
                                    <button
                                        key={item.color}
                                        type="button"
                                        onClick={(e) => {
                                            e.preventDefault();
                                            editor.chain().focus().toggleHighlight({ color: item.color }).run();
                                            setShowHighlightPicker(false);
                                        }}
                                        onMouseDown={(e) => e.preventDefault()}
                                        className="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-500 transition-colors"
                                        style={{ backgroundColor: item.color }}
                                        title={item.name}
                                    />
                                ))}
                                <button
                                    type="button"
                                    onClick={(e) => {
                                        e.preventDefault();
                                        editor.chain().focus().unsetHighlight().run();
                                        setShowHighlightPicker(false);
                                    }}
                                    onMouseDown={(e) => e.preventDefault()}
                                    className="col-span-5 px-2 py-1 text-xs bg-gray-100 hover:bg-gray-200 rounded"
                                    title="Remove Highlight"
                                >
                                    Remove Highlight
                                </button>
                            </div>
                        )}
                    </div>

                    <div className="w-px bg-gray-300 mx-1" />

                    <MenuButton
                        onClick={() => {
                            const url = window.prompt('URL:', 'https://');
                            if (url) {
                                editor.chain().focus().setLink({ href: url }).run();
                            }
                        }}
                        isActive={editor.isActive('link')}
                        title="Insert Link"
                    >
                        Link
                    </MenuButton>
                    <MenuButton
                        onClick={() => {
                            const url = window.prompt('YouTube URL:', 'https://www.youtube.com/watch?v=');
                            if (url) {
                                editor.commands.setYoutubeVideo({ src: url });
                            }
                        }}
                        isActive={editor.isActive('youtube')}
                        title="Insert YouTube Video"
                    >
                        📺 YouTube
                    </MenuButton>
                    <div className="relative">
                        <MenuButton
                            onClick={() => setShowImageUpload(!showImageUpload)}
                            isActive={showImageUpload}
                            title="Insert Image"
                        >
                            🖼 Image
                        </MenuButton>

                        {showImageUpload && (
                            <div className="absolute top-full left-0 mt-1 bg-white border border-gray-300 rounded-lg shadow-lg p-4 z-50 w-72">
                                <div className="space-y-3">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">
                                            Upload from Computer
                                        </label>
                                        <input
                                            type="file"
                                            accept="image/*"
                                            onChange={async (e) => {
                                                const file = e.target.files[0];
                                                if (!file) return;

                                                setUploading(true);
                                                const formData = new FormData();
                                                formData.append('file', file);
                                                formData.append('title', file.name);
                                                formData.append('alt_text', file.name);

                                                try {
                                                    const response = await fetch('/admin/media', {
                                                        method: 'POST',
                                                        body: formData,
                                                        headers: {
                                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                                            'Accept': 'application/json',
                                                        },
                                                        credentials: 'same-origin',
                                                    });

                                                    const result = await response.json();

                                                    if (response.ok && result.media) {
                                                        editor.chain().focus().setImage({ src: result.media.file_path }).run();
                                                        setShowImageUpload(false);
                                                    } else {
                                                        alert('Failed to upload image');
                                                    }
                                                } catch (error) {
                                                    console.error('Upload error:', error);
                                                    alert('Failed to upload image');
                                                } finally {
                                                    setUploading(false);
                                                    e.target.value = '';
                                                }
                                            }}
                                            disabled={uploading}
                                            className="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 disabled:opacity-50"
                                        />
                                        {uploading && (
                                            <p className="text-xs text-blue-600 mt-1">Uploading...</p>
                                        )}
                                    </div>

                                    <div className="relative">
                                        <div className="absolute inset-0 flex items-center">
                                            <div className="w-full border-t border-gray-300"></div>
                                        </div>
                                        <div className="relative flex justify-center text-xs">
                                            <span className="px-2 bg-white text-gray-500">OR</span>
                                        </div>
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">
                                            Image URL
                                        </label>
                                        <input
                                            type="text"
                                            placeholder="https://..."
                                            className="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm"
                                            onKeyDown={(e) => {
                                                if (e.key === 'Enter') {
                                                    e.preventDefault();
                                                    const url = e.target.value.trim();
                                                    if (url) {
                                                        editor.chain().focus().setImage({ src: url }).run();
                                                        setShowImageUpload(false);
                                                        e.target.value = '';
                                                    }
                                                }
                                            }}
                                        />
                                        <p className="text-xs text-gray-500 mt-1">Press Enter to insert</p>
                                    </div>

                                    <button
                                        type="button"
                                        onClick={() => setShowImageUpload(false)}
                                        className="w-full px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        )}
                    </div>
                    <MenuButton
                        onClick={() => editor.chain().focus().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run()}
                        isActive={false}
                        title="Insert Table"
                    >
                        Table
                    </MenuButton>

                    {editor.isActive('table') && (
                        <>
                            <MenuButton
                                onClick={() => editor.chain().focus().addColumnBefore().run()}
                                isActive={false}
                                title="Add Column Before"
                            >
                                ← Col
                            </MenuButton>
                            <MenuButton
                                onClick={() => editor.chain().focus().addColumnAfter().run()}
                                isActive={false}
                                title="Add Column After"
                            >
                                Col →
                            </MenuButton>
                            <MenuButton
                                onClick={() => editor.chain().focus().deleteColumn().run()}
                                isActive={false}
                                title="Delete Column"
                            >
                                ✕ Col
                            </MenuButton>
                            <MenuButton
                                onClick={() => editor.chain().focus().addRowBefore().run()}
                                isActive={false}
                                title="Add Row Before"
                            >
                                ↑ Row
                            </MenuButton>
                            <MenuButton
                                onClick={() => editor.chain().focus().addRowAfter().run()}
                                isActive={false}
                                title="Add Row After"
                            >
                                Row ↓
                            </MenuButton>
                            <MenuButton
                                onClick={() => editor.chain().focus().deleteRow().run()}
                                isActive={false}
                                title="Delete Row"
                            >
                                ✕ Row
                            </MenuButton>
                            <MenuButton
                                onClick={() => editor.chain().focus().deleteTable().run()}
                                isActive={false}
                                title="Delete Table"
                            >
                                ✕ Table
                            </MenuButton>
                        </>
                    )}

                    <div className="w-px bg-gray-300 mx-1" />

                    {/* Text Color Buttons */}
                    <div className="relative">
                        <MenuButton
                            onClick={() => setShowColorPicker(!showColorPicker)}
                            isActive={showColorPicker}
                            title="Text Color"
                        >
                            🎨 Color
                        </MenuButton>

                        {showColorPicker && (
                            <div
                                className="absolute top-full left-0 mt-1 bg-white border border-gray-300 rounded-lg shadow-lg p-2 z-50 grid grid-cols-5 gap-1"
                                style={{ width: 'max-content' }}
                            >
                                {[
                                    { name: 'Black', color: '#000000' },
                                    { name: 'Gray', color: '#6B7280' },
                                    { name: 'Red', color: '#EF4444' },
                                    { name: 'Orange', color: '#F97316' },
                                    { name: 'Yellow', color: '#EAB308' },
                                    { name: 'Green', color: '#22C55E' },
                                    { name: 'Blue', color: '#3B82F6' },
                                    { name: 'Indigo', color: '#6366F1' },
                                    { name: 'Purple', color: '#A855F7' },
                                    { name: 'Pink', color: '#EC4899' },
                                ].map((item) => (
                                    <button
                                        key={item.color}
                                        type="button"
                                        onClick={(e) => {
                                            e.preventDefault();
                                            editor.chain().focus().setColor(item.color).run();
                                            setShowColorPicker(false);
                                        }}
                                        onMouseDown={(e) => e.preventDefault()}
                                        className="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-500 transition-colors"
                                        style={{ backgroundColor: item.color }}
                                        title={item.name}
                                    />
                                ))}
                                <button
                                    type="button"
                                    onClick={(e) => {
                                        e.preventDefault();
                                        editor.chain().focus().unsetColor().run();
                                        setShowColorPicker(false);
                                    }}
                                    onMouseDown={(e) => e.preventDefault()}
                                    className="col-span-5 px-2 py-1 text-xs bg-gray-100 hover:bg-gray-200 rounded"
                                    title="Reset Color"
                                >
                                    Reset Color
                                </button>
                            </div>
                        )}
                    </div>

                    <div className="w-px bg-gray-300 mx-1" />

                    <MenuButton
                        onClick={() => editor.chain().focus().undo().run()}
                        isActive={false}
                        title="Undo"
                    >
                        ↶
                    </MenuButton>
                    <MenuButton
                        onClick={() => editor.chain().focus().redo().run()}
                        isActive={false}
                        title="Redo"
                    >
                        ↷
                    </MenuButton>

                    <div className="w-px bg-gray-300 mx-1" />

                    <MenuButton
                        onClick={() => setShowHtml(!showHtml)}
                        isActive={showHtml}
                        title="View HTML Code"
                    >
                        {'<> HTML'}
                    </MenuButton>
                </div>

                {/* Editor Content or HTML View */}
                {!showHtml ? (
                    <div className="bg-white relative" style={{ minHeight: `${height}px` }}>
                        {/* Image Floating Menu */}
                        {showImageMenu && editor && (
                            <div
                                className="image-menu fixed bg-gray-800 text-white rounded-lg shadow-xl p-3 space-y-2 z-50"
                                style={{
                                    top: `${imageMenuPosition.top}px`,
                                    left: `${imageMenuPosition.left}px`,
                                    minWidth: '250px',
                                }}
                                onClick={(e) => e.stopPropagation()}
                            >
                                <div className="flex justify-between items-center mb-2">
                                    <div className="text-xs font-semibold text-gray-300">Image Settings</div>
                                    <button
                                        type="button"
                                        onClick={() => setShowImageMenu(false)}
                                        className="text-gray-400 hover:text-white"
                                    >
                                        ✕
                                    </button>
                                </div>

                                {/* Width & Height */}
                                <div className="flex gap-2 items-center">
                                    <label className="text-xs text-gray-300 w-12">Width:</label>
                                    <input
                                        type="number"
                                        placeholder="auto"
                                        className="w-20 px-2 py-1 text-xs bg-gray-700 border border-gray-600 rounded text-white"
                                        onKeyDown={(e) => {
                                            if (e.key === 'Enter') {
                                                e.preventDefault();
                                                const value = e.target.value;
                                                if (value) {
                                                    editor.commands.updateAttributes('image', { width: value + 'px' });
                                                } else {
                                                    editor.commands.updateAttributes('image', { width: null });
                                                }
                                            }
                                        }}
                                        onBlur={(e) => {
                                            const value = e.target.value;
                                            if (value) {
                                                editor.commands.updateAttributes('image', { width: value + 'px' });
                                            } else {
                                                editor.commands.updateAttributes('image', { width: null });
                                            }
                                        }}
                                    />
                                    <span className="text-xs text-gray-400">px</span>
                                </div>

                                <div className="flex gap-2 items-center">
                                    <label className="text-xs text-gray-300 w-12">Height:</label>
                                    <input
                                        type="number"
                                        placeholder="auto"
                                        className="w-20 px-2 py-1 text-xs bg-gray-700 border border-gray-600 rounded text-white"
                                        onKeyDown={(e) => {
                                            if (e.key === 'Enter') {
                                                e.preventDefault();
                                                const value = e.target.value;
                                                if (value) {
                                                    editor.commands.updateAttributes('image', { height: value + 'px' });
                                                } else {
                                                    editor.commands.updateAttributes('image', { height: null });
                                                }
                                            }
                                        }}
                                        onBlur={(e) => {
                                            const value = e.target.value;
                                            if (value) {
                                                editor.commands.updateAttributes('image', { height: value + 'px' });
                                            } else {
                                                editor.commands.updateAttributes('image', { height: null });
                                            }
                                        }}
                                    />
                                    <span className="text-xs text-gray-400">px</span>
                                </div>

                                {/* Alignment */}
                                <div className="pt-2 border-t border-gray-700">
                                    <div className="text-xs text-gray-300 mb-1">Align:</div>
                                    <div className="flex gap-1">
                                        <button
                                            type="button"
                                            onClick={(e) => {
                                                e.preventDefault();
                                                editor.commands.updateAttributes('image', {
                                                    style: 'display: block; margin-left: 0; margin-right: auto;'
                                                });
                                            }}
                                            className="px-2 py-1 text-xs bg-gray-700 hover:bg-gray-600 rounded"
                                            title="Align Left"
                                        >
                                            ⬅ Left
                                        </button>
                                        <button
                                            type="button"
                                            onClick={(e) => {
                                                e.preventDefault();
                                                editor.commands.updateAttributes('image', {
                                                    style: 'display: block; margin-left: auto; margin-right: auto;'
                                                });
                                            }}
                                            className="px-2 py-1 text-xs bg-gray-700 hover:bg-gray-600 rounded"
                                            title="Align Center"
                                        >
                                            ↔ Center
                                        </button>
                                        <button
                                            type="button"
                                            onClick={(e) => {
                                                e.preventDefault();
                                                editor.commands.updateAttributes('image', {
                                                    style: 'display: block; margin-left: auto; margin-right: 0;'
                                                });
                                            }}
                                            className="px-2 py-1 text-xs bg-gray-700 hover:bg-gray-600 rounded"
                                            title="Align Right"
                                        >
                                            Right ➡
                                        </button>
                                    </div>
                                </div>

                                {/* Spacing */}
                                <div className="pt-2 border-t border-gray-700">
                                    <div className="text-xs text-gray-300 mb-1">Spacing (margin):</div>
                                    <div className="flex gap-2">
                                        <button
                                            type="button"
                                            onClick={(e) => {
                                                e.preventDefault();
                                                const currentStyle = editor.getAttributes('image').style || '';
                                                const newStyle = currentStyle.replace(/margin:\s*\d+px;?/g, '') + ' margin: 10px;';
                                                editor.commands.updateAttributes('image', {
                                                    style: newStyle.trim()
                                                });
                                            }}
                                            className="px-2 py-1 text-xs bg-gray-700 hover:bg-gray-600 rounded"
                                        >
                                            10px
                                        </button>
                                        <button
                                            type="button"
                                            onClick={(e) => {
                                                e.preventDefault();
                                                const currentStyle = editor.getAttributes('image').style || '';
                                                const newStyle = currentStyle.replace(/margin:\s*\d+px;?/g, '') + ' margin: 20px;';
                                                editor.commands.updateAttributes('image', {
                                                    style: newStyle.trim()
                                                });
                                            }}
                                            className="px-2 py-1 text-xs bg-gray-700 hover:bg-gray-600 rounded"
                                        >
                                            20px
                                        </button>
                                        <button
                                            type="button"
                                            onClick={(e) => {
                                                e.preventDefault();
                                                const currentStyle = editor.getAttributes('image').style || '';
                                                const newStyle = currentStyle.replace(/margin:\s*\d+px;?/g, '');
                                                editor.commands.updateAttributes('image', {
                                                    style: newStyle.trim()
                                                });
                                            }}
                                            className="px-2 py-1 text-xs bg-gray-700 hover:bg-gray-600 rounded"
                                        >
                                            None
                                        </button>
                                    </div>
                                </div>

                                {/* Delete Image */}
                                <div className="pt-2 border-t border-gray-700">
                                    <button
                                        type="button"
                                        onClick={(e) => {
                                            e.preventDefault();
                                            editor.commands.deleteSelection();
                                            setShowImageMenu(false);
                                        }}
                                        className="w-full px-2 py-1 text-xs bg-red-600 hover:bg-red-700 rounded"
                                    >
                                        🗑 Delete Image
                                    </button>
                                </div>
                            </div>
                        )}

                        <EditorContent editor={editor} />
                    </div>
                ) : (
                    <div className="bg-white p-4" style={{ minHeight: `${height}px` }}>
                        <textarea
                            className="w-full h-full min-h-[400px] font-mono text-sm p-4 border border-gray-300 rounded"
                            value={editor.getHTML()}
                            onChange={(e) => {
                                editor.commands.setContent(e.target.value);
                                if (onChange) {
                                    onChange(e.target.value);
                                }
                            }}
                            style={{ fontFamily: 'monospace' }}
                        />
                    </div>
                )}
            </div>
            {error && <p className="mt-1 text-sm text-red-600">{error}</p>}
        </div>
    );
}