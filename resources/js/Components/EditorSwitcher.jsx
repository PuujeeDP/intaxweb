import { usePage } from '@inertiajs/react';
import RichTextEditor from './RichTextEditor';
import TinyMCEEditor from './TinyMCEEditor';

export default function EditorSwitcher({ label, value, onChange, error, className = '', height = 500 }) {
    const { settings } = usePage().props;

    // Get editor type from settings
    const getEditorType = () => {
        if (!settings || !settings.general) return 'tiptap';

        const editorSetting = settings.general.find(s => s.key === 'general_editor_type');
        return editorSetting ? editorSetting.value : 'tiptap';
    };

    const editorType = getEditorType();

    // If TinyMCE is selected, use TinyMCE
    if (editorType === 'tinymce') {
        return (
            <div className={className}>
                {label && (
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                        {label}
                    </label>
                )}
                <TinyMCEEditor
                    value={value}
                    onChange={onChange}
                    height={height}
                />
                {error && (
                    <p className="mt-1 text-sm text-red-600">{error}</p>
                )}
            </div>
        );
    }

    // Default to TipTap
    return (
        <RichTextEditor
            label={label}
            value={value}
            onChange={onChange}
            error={error}
            className={className}
            height={height}
        />
    );
}
