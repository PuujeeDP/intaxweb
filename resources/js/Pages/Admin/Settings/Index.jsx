import { useForm } from "@inertiajs/react";
import { useState } from "react";
import AppLayout from "../../../Layouts/AppLayout";
import TextInput from "../../../Components/TextInput";
import TextArea from "../../../Components/TextArea";

export default function SettingsIndex({ settings, logo, favicon }) {
    const [uploadingLogo, setUploadingLogo] = useState(false);
    const [uploadingFavicon, setUploadingFavicon] = useState(false);
    const [logoPreview, setLogoPreview] = useState(logo?.file_path || null);
    const [faviconPreview, setFaviconPreview] = useState(favicon?.file_path || null);

    const getSetting = (group, key) => {
        const fullKey = `${group}_${key}`;
        if (!settings[group]) return '';
        const setting = settings[group].find(s => s.key === fullKey);
        return setting ? setting.value : '';
    };

    const initialData = {
        general: {
            site_name: getSetting('general', 'site_name'),
            site_description: getSetting('general', 'site_description'),
            logo: logo?.id || '',
            favicon: favicon?.id || '',
            primary_color: getSetting('general', 'primary_color') || '#dc2626',
            default_locale: getSetting('general', 'default_locale') || 'mn',
            enabled_locales: getSetting('general', 'enabled_locales') || 'en,mn,zh',
            editor_type: getSetting('general', 'editor_type') || 'tiptap',
        },
        contact: {
            email: getSetting('contact', 'email'),
            phone: getSetting('contact', 'phone'),
            address: getSetting('contact', 'address'),
        },
        social: {
            facebook: getSetting('social', 'facebook'),
            twitter: getSetting('social', 'twitter'),
            instagram: getSetting('social', 'instagram'),
            linkedin: getSetting('social', 'linkedin'),
            youtube: getSetting('social', 'youtube'),
        },
        footer: {
            copyright: getSetting('footer', 'copyright'),
            about_text: getSetting('footer', 'about_text'),
        },
    };

    const { data, setData, put, processing, errors } = useForm(initialData);

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route('admin.settings.update'));
    };

    const updateField = (group, field, value) => {
        setData(group, {
            ...data[group],
            [field]: value,
        });
    };

    const toggleLocale = (locale) => {
        const enabledLocales = data.general.enabled_locales.split(',').filter(l => l);
        const index = enabledLocales.indexOf(locale);

        if (index > -1) {
            // Remove if exists
            enabledLocales.splice(index, 1);
        } else {
            // Add if doesn't exist
            enabledLocales.push(locale);
        }

        // At least one locale must be enabled
        if (enabledLocales.length === 0) {
            alert('At least one language must be enabled');
            return;
        }

        updateField('general', 'enabled_locales', enabledLocales.join(','));

        // If default locale is disabled, change it to first enabled locale
        if (!enabledLocales.includes(data.general.default_locale)) {
            updateField('general', 'default_locale', enabledLocales[0]);
        }
    };

    const isLocaleEnabled = (locale) => {
        const enabledLocales = data.general.enabled_locales.split(',').filter(l => l);
        return enabledLocales.includes(locale);
    };

    const handleImageUpload = async (e, type) => {
        const file = e.target.files[0];
        if (!file) return;

        if (type === 'logo') {
            setUploadingLogo(true);
        } else {
            setUploadingFavicon(true);
        }

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
                if (type === 'logo') {
                    updateField('general', 'logo', result.media.id);
                    setLogoPreview(result.media.file_path);
                } else {
                    updateField('general', 'favicon', result.media.id);
                    setFaviconPreview(result.media.file_path);
                }
            } else {
                alert('Failed to upload image');
            }
        } catch (error) {
            console.error('Upload error:', error);
            alert('Failed to upload image');
        } finally {
            if (type === 'logo') {
                setUploadingLogo(false);
            } else {
                setUploadingFavicon(false);
            }
        }
    };

    const removeImage = (type) => {
        if (type === 'logo') {
            updateField('general', 'logo', '');
            setLogoPreview(null);
        } else {
            updateField('general', 'favicon', '');
            setFaviconPreview(null);
        }
    };

    return (
        <AppLayout title="Site Settings">
            <div className="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <div className="px-4 py-6 sm:px-0">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            <h2 className="text-2xl font-bold mb-6">Site Settings</h2>

                            <form onSubmit={handleSubmit}>
                                {/* General Settings */}
                                <div className="mb-8">
                                    <h3 className="text-xl font-semibold mb-4 pb-2 border-b">General Settings</h3>
                                    <div className="space-y-4">
                                        <TextInput
                                            label="Site Name"
                                            value={data.general.site_name}
                                            onChange={(e) => updateField('general', 'site_name', e.target.value)}
                                            error={errors['general.site_name']}
                                        />
                                        <TextArea
                                            label="Site Description"
                                            value={data.general.site_description}
                                            onChange={(e) => updateField('general', 'site_description', e.target.value)}
                                            error={errors['general.site_description']}
                                            rows={3}
                                        />

                                        {/* Logo Upload */}
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                Site Logo
                                            </label>
                                            {logoPreview && (
                                                <div className="mb-2 relative inline-block">
                                                    <img
                                                        src={logoPreview}
                                                        alt="Logo Preview"
                                                        className="h-20 w-auto object-contain border rounded"
                                                    />
                                                    <button
                                                        type="button"
                                                        onClick={() => removeImage('logo')}
                                                        className="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
                                                    >
                                                        <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            )}
                                            <input
                                                type="file"
                                                accept="image/*"
                                                onChange={(e) => handleImageUpload(e, 'logo')}
                                                disabled={uploadingLogo}
                                                className="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                            />
                                            {uploadingLogo && <p className="text-sm text-gray-500 mt-1">Uploading...</p>}
                                            {errors['general.logo'] && <p className="text-sm text-red-600 mt-1">{errors['general.logo']}</p>}
                                        </div>

                                        {/* Favicon Upload */}
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                Favicon
                                            </label>
                                            {faviconPreview && (
                                                <div className="mb-2 relative inline-block">
                                                    <img
                                                        src={faviconPreview}
                                                        alt="Favicon Preview"
                                                        className="h-12 w-12 object-contain border rounded"
                                                    />
                                                    <button
                                                        type="button"
                                                        onClick={() => removeImage('favicon')}
                                                        className="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
                                                    >
                                                        <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            )}
                                            <input
                                                type="file"
                                                accept="image/*"
                                                onChange={(e) => handleImageUpload(e, 'favicon')}
                                                disabled={uploadingFavicon}
                                                className="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                            />
                                            {uploadingFavicon && <p className="text-sm text-gray-500 mt-1">Uploading...</p>}
                                            {errors['general.favicon'] && <p className="text-sm text-red-600 mt-1">{errors['general.favicon']}</p>}
                                        </div>

                                        {/* Primary Color */}
                                        <div>
                                            <label htmlFor="primary_color" className="block text-sm font-medium text-gray-700 mb-2">
                                                Primary Color
                                            </label>
                                            <div className="flex items-center space-x-4">
                                                <input
                                                    type="color"
                                                    id="primary_color"
                                                    value={data.general.primary_color}
                                                    onChange={(e) => updateField('general', 'primary_color', e.target.value)}
                                                    className="h-12 w-20 border-2 border-gray-300 rounded cursor-pointer"
                                                />
                                                <input
                                                    type="text"
                                                    value={data.general.primary_color}
                                                    onChange={(e) => updateField('general', 'primary_color', e.target.value)}
                                                    placeholder="#dc2626"
                                                    className="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                                />
                                                <div
                                                    className="w-12 h-12 rounded border-2 border-gray-300"
                                                    style={{ backgroundColor: data.general.primary_color }}
                                                ></div>
                                            </div>
                                            {errors['general.primary_color'] && <p className="text-sm text-red-600 mt-1">{errors['general.primary_color']}</p>}
                                            <p className="text-xs text-gray-500 mt-1">Choose the primary color for your website (e.g., buttons, links)</p>
                                        </div>

                                        {/* Enabled Languages */}
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                Enabled Languages / Идэвхтэй хэлүүд
                                            </label>
                                            <div className="space-y-2">
                                                <label className="flex items-center space-x-3">
                                                    <input
                                                        type="checkbox"
                                                        checked={isLocaleEnabled('mn')}
                                                        onChange={() => toggleLocale('mn')}
                                                        className="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                    />
                                                    <span className="text-sm text-gray-700">Монгол (Mongolian)</span>
                                                </label>
                                                <label className="flex items-center space-x-3">
                                                    <input
                                                        type="checkbox"
                                                        checked={isLocaleEnabled('en')}
                                                        onChange={() => toggleLocale('en')}
                                                        className="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                    />
                                                    <span className="text-sm text-gray-700">English (Англи)</span>
                                                </label>
                                                <label className="flex items-center space-x-3">
                                                    <input
                                                        type="checkbox"
                                                        checked={isLocaleEnabled('zh')}
                                                        onChange={() => toggleLocale('zh')}
                                                        className="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                    />
                                                    <span className="text-sm text-gray-700">中文 (Chinese / Хятад)</span>
                                                </label>
                                            </div>
                                            {errors['general.enabled_locales'] && <p className="text-sm text-red-600 mt-1">{errors['general.enabled_locales']}</p>}
                                            <p className="text-xs text-gray-500 mt-1">Select which languages to enable on your website (at least one required)</p>
                                        </div>

                                        {/* Default Locale */}
                                        <div>
                                            <label htmlFor="default_locale" className="block text-sm font-medium text-gray-700 mb-2">
                                                Default Language / Үндсэн хэл
                                            </label>
                                            <select
                                                id="default_locale"
                                                value={data.general.default_locale}
                                                onChange={(e) => updateField('general', 'default_locale', e.target.value)}
                                                className="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                            >
                                                {isLocaleEnabled('mn') && <option value="mn">Монгол (Mongolian)</option>}
                                                {isLocaleEnabled('en') && <option value="en">English (Англи)</option>}
                                                {isLocaleEnabled('zh') && <option value="zh">中文 (Chinese / Хятад)</option>}
                                            </select>
                                            {errors['general.default_locale'] && <p className="text-sm text-red-600 mt-1">{errors['general.default_locale']}</p>}
                                            <p className="text-xs text-gray-500 mt-1">Choose the default language for your website (must be one of the enabled languages)</p>
                                        </div>

                                        {/* Rich Text Editor Type */}
                                        <div>
                                            <label htmlFor="editor_type" className="block text-sm font-medium text-gray-700 mb-2">
                                                Rich Text Editor / Текст засварлагч
                                            </label>
                                            <select
                                                id="editor_type"
                                                value={data.general.editor_type}
                                                onChange={(e) => updateField('general', 'editor_type', e.target.value)}
                                                className="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                            >
                                                <option value="tiptap">TipTap (Modern, Lightweight)</option>
                                                <option value="tinymce">TinyMCE (Classic, Feature-rich)</option>
                                            </select>
                                            {errors['general.editor_type'] && <p className="text-sm text-red-600 mt-1">{errors['general.editor_type']}</p>}
                                            <p className="text-xs text-gray-500 mt-1">
                                                Choose which rich text editor to use in admin panel. TipTap is modern and fast, TinyMCE offers more traditional features.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {/* Contact Settings */}
                                <div className="mb-8">
                                    <h3 className="text-xl font-semibold mb-4 pb-2 border-b">Contact Information</h3>
                                    <div className="space-y-4">
                                        <TextInput
                                            label="Email"
                                            type="email"
                                            value={data.contact.email}
                                            onChange={(e) => updateField('contact', 'email', e.target.value)}
                                            error={errors['contact.email']}
                                        />
                                        <TextInput
                                            label="Phone"
                                            value={data.contact.phone}
                                            onChange={(e) => updateField('contact', 'phone', e.target.value)}
                                            error={errors['contact.phone']}
                                        />
                                        <TextArea
                                            label="Address"
                                            value={data.contact.address}
                                            onChange={(e) => updateField('contact', 'address', e.target.value)}
                                            error={errors['contact.address']}
                                            rows={3}
                                        />
                                    </div>
                                </div>

                                {/* Social Media Settings */}
                                <div className="mb-8">
                                    <h3 className="text-xl font-semibold mb-4 pb-2 border-b">Social Media</h3>
                                    <div className="space-y-4">
                                        <TextInput
                                            label="Facebook URL"
                                            type="url"
                                            value={data.social.facebook}
                                            onChange={(e) => updateField('social', 'facebook', e.target.value)}
                                            error={errors['social.facebook']}
                                            placeholder="https://facebook.com/yourpage"
                                        />
                                        <TextInput
                                            label="Twitter URL"
                                            type="url"
                                            value={data.social.twitter}
                                            onChange={(e) => updateField('social', 'twitter', e.target.value)}
                                            error={errors['social.twitter']}
                                            placeholder="https://twitter.com/yourhandle"
                                        />
                                        <TextInput
                                            label="Instagram URL"
                                            type="url"
                                            value={data.social.instagram}
                                            onChange={(e) => updateField('social', 'instagram', e.target.value)}
                                            error={errors['social.instagram']}
                                            placeholder="https://instagram.com/yourhandle"
                                        />
                                        <TextInput
                                            label="LinkedIn URL"
                                            type="url"
                                            value={data.social.linkedin}
                                            onChange={(e) => updateField('social', 'linkedin', e.target.value)}
                                            error={errors['social.linkedin']}
                                            placeholder="https://linkedin.com/company/yourcompany"
                                        />
                                        <TextInput
                                            label="YouTube URL"
                                            type="url"
                                            value={data.social.youtube}
                                            onChange={(e) => updateField('social', 'youtube', e.target.value)}
                                            error={errors['social.youtube']}
                                            placeholder="https://youtube.com/@yourchannel"
                                        />
                                    </div>
                                </div>

                                {/* Footer Settings */}
                                <div className="mb-8">
                                    <h3 className="text-xl font-semibold mb-4 pb-2 border-b">Footer Settings</h3>
                                    <div className="space-y-4">
                                        <TextInput
                                            label="Copyright Text"
                                            value={data.footer.copyright}
                                            onChange={(e) => updateField('footer', 'copyright', e.target.value)}
                                            error={errors['footer.copyright']}
                                            placeholder="© 2025 Your Company. All rights reserved."
                                        />
                                        <TextArea
                                            label="About Text"
                                            value={data.footer.about_text}
                                            onChange={(e) => updateField('footer', 'about_text', e.target.value)}
                                            error={errors['footer.about_text']}
                                            rows={4}
                                            placeholder="Short description about your company..."
                                        />
                                    </div>
                                </div>

                                {/* Submit Button */}
                                <div className="flex items-center justify-end mt-6">
                                    <button
                                        type="submit"
                                        disabled={processing}
                                        className="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline disabled:opacity-50"
                                    >
                                        {processing ? 'Saving...' : 'Save Settings'}
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
