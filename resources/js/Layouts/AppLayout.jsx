import { Link, usePage } from '@inertiajs/react';
import { useState } from 'react';

export default function AppLayout({ children }) {
    const { auth } = usePage().props;
    const [sidebarOpen, setSidebarOpen] = useState(true);

    const navigation = [
        { name: 'Dashboard', href: '/admin/dashboard', icon: '📊' },
        { name: 'Posts', href: '/admin/posts', icon: '📝' },
        { name: 'Pages', href: '/admin/pages', icon: '📄' },
        { name: 'Categories', href: '/admin/categories', icon: '🗂️' },
        { name: 'Services', href: '/admin/services', icon: '🛠️' },
        { name: 'Sliders', href: '/admin/sliders', icon: '🎬' },
        { name: 'Team', href: '/admin/team', icon: '👨‍💼' },
        { name: 'Clients', href: '/admin/clients', icon: '🤝' },
        { name: 'Testimonials', href: '/admin/testimonials', icon: '💬' },
        { name: 'Company History', href: '/admin/company-histories', icon: '📅' },
        { name: 'Widgets', href: '/admin/widgets', icon: '🧩' },
        { name: 'Media', href: '/admin/media', icon: '🖼️' },
        { name: 'Menus', href: '/admin/menus', icon: '🔗' },
        { name: 'Users', href: '/admin/users', icon: '👥' },
        { name: 'Settings', href: '/admin/settings', icon: '⚙️' },
    ];

    return (
        <div className="min-h-screen bg-gray-100">
            {/* Sidebar */}
            <div className={`fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 transform transition-transform duration-200 ease-in-out ${sidebarOpen ? 'translate-x-0' : '-translate-x-full'}`}>
                <div className="flex items-center justify-between h-16 px-4 bg-gray-800">
                    <Link href="/admin/dashboard" className="text-xl font-bold text-white">
                        MagicCMS
                    </Link>
                    <button
                        onClick={() => setSidebarOpen(!sidebarOpen)}
                        className="text-gray-400 hover:text-white lg:hidden"
                    >
                        ✕
                    </button>
                </div>

                <nav className="mt-8 px-4 space-y-1">
                    {navigation.map((item) => (
                        <Link
                            key={item.name}
                            href={item.href}
                            className="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors"
                        >
                            <span className="mr-3 text-xl">{item.icon}</span>
                            {item.name}
                        </Link>
                    ))}
                </nav>

                <div className="absolute bottom-0 w-full p-4 border-t border-gray-800">
                    <div className="flex items-center">
                        <div className="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center text-white">
                            {auth.user?.name?.charAt(0)}
                        </div>
                        <div className="ml-3">
                            <p className="text-sm font-medium text-white">{auth.user?.name}</p>
                            <Link
                                href="/logout"
                                method="post"
                                as="button"
                                className="text-xs text-gray-400 hover:text-white"
                            >
                                Logout
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            {/* Main content */}
            <div className={`transition-all duration-200 ${sidebarOpen ? 'lg:pl-64' : ''}`}>
                {/* Top bar */}
                <div className="sticky top-0 z-40 h-16 bg-white border-b border-gray-200">
                    <div className="flex items-center justify-between h-full px-4">
                        <button
                            onClick={() => setSidebarOpen(!sidebarOpen)}
                            className="text-gray-500 hover:text-gray-700"
                        >
                            <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div className="flex items-center space-x-4">
                            <span className="text-sm text-gray-600">Welcome, {auth.user?.name}</span>
                        </div>
                    </div>
                </div>

                {/* Page content */}
                <main className="p-6">
                    {children}
                </main>
            </div>
        </div>
    );
}
