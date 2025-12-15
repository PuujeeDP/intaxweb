import AppLayout from '../Layouts/AppLayout';
import { Head } from '@inertiajs/react';

export default function Dashboard({ stats }) {
    const cards = [
        { name: 'Total Posts', value: stats?.posts || 0, icon: '📝', color: 'bg-blue-500' },
        { name: 'Total Pages', value: stats?.pages || 0, icon: '📄', color: 'bg-green-500' },
        { name: 'Total Users', value: stats?.users || 0, icon: '👥', color: 'bg-purple-500' },
        { name: 'Media Files', value: stats?.media || 0, icon: '🖼️', color: 'bg-yellow-500' },
    ];

    return (
        <AppLayout>
            <Head title="Dashboard" />

            <div className="mb-6">
                <h1 className="text-3xl font-bold text-gray-900">Dashboard</h1>
                <p className="mt-2 text-gray-600">Welcome to MagicCMS Admin Panel</p>
            </div>

            {/* Stats Grid */}
            <div className="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
                {cards.map((card) => (
                    <div key={card.name} className="bg-white rounded-lg shadow-md overflow-hidden">
                        <div className="p-6">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm font-medium text-gray-600">{card.name}</p>
                                    <p className="mt-2 text-3xl font-bold text-gray-900">{card.value}</p>
                                </div>
                                <div className={`p-3 rounded-full ${card.color} text-white text-2xl`}>
                                    {card.icon}
                                </div>
                            </div>
                        </div>
                    </div>
                ))}
            </div>

            {/* Recent Activity */}
            <div className="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <div className="bg-white rounded-lg shadow-md">
                    <div className="p-6 border-b border-gray-200">
                        <h2 className="text-lg font-semibold text-gray-900">Recent Posts</h2>
                    </div>
                    <div className="p-6">
                        <p className="text-gray-500 text-center py-8">No recent posts</p>
                    </div>
                </div>

                <div className="bg-white rounded-lg shadow-md">
                    <div className="p-6 border-b border-gray-200">
                        <h2 className="text-lg font-semibold text-gray-900">System Info</h2>
                    </div>
                    <div className="p-6 space-y-4">
                        <div className="flex justify-between">
                            <span className="text-gray-600">Laravel Version</span>
                            <span className="font-semibold">12.x</span>
                        </div>
                        <div className="flex justify-between">
                            <span className="text-gray-600">Database</span>
                            <span className="font-semibold">PostgreSQL</span>
                        </div>
                        <div className="flex justify-between">
                            <span className="text-gray-600">Frontend</span>
                            <span className="font-semibold">React + Inertia</span>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
