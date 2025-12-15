import { useState } from 'react';

export default function LanguageTabs({ locales, children, defaultLocale = 'en' }) {
    const [activeLocale, setActiveLocale] = useState(defaultLocale);

    return (
        <div>
            {/* Tabs */}
            <div className="border-b border-gray-200">
                <nav className="-mb-px flex space-x-8">
                    {Object.entries(locales).map(([code, name]) => (
                        <button
                            key={code}
                            type="button"
                            onClick={() => setActiveLocale(code)}
                            className={`py-2 px-1 border-b-2 font-medium text-sm transition-colors ${
                                activeLocale === code
                                    ? 'border-blue-500 text-blue-600'
                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                            }`}
                        >
                            {name}
                        </button>
                    ))}
                </nav>
            </div>

            {/* Tab Content */}
            <div className="mt-4">
                {children(activeLocale)}
            </div>
        </div>
    );
}
