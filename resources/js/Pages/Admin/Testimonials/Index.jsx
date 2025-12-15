import { Head, Link, usePage, router } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';

export default function Index() {
    const { testimonials } = usePage().props;

    const deleteTestimonial = (id) => {
        if (confirm('Are you sure you want to delete this testimonial?')) {
            router.delete(route('admin.testimonials.destroy', id));
        }
    };

    const renderStars = (rating) => {
        return [...Array(5)].map((_, index) => (
            <span key={index} className={index < rating ? 'text-yellow-400' : 'text-gray-300'}>
                ★
            </span>
        ));
    };

    return (
        <AppLayout>
            <Head title="Testimonials" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            <div className="flex justify-between items-center mb-6">
                                <h2 className="text-2xl font-bold text-gray-800">Testimonials</h2>
                                <Link
                                    href={route('admin.testimonials.create')}
                                    className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                    Add New Testimonial
                                </Link>
                            </div>

                            {testimonials.length === 0 ? (
                                <p className="text-gray-500">No testimonials found. Create your first testimonial!</p>
                            ) : (
                                <div className="overflow-x-auto">
                                    <table className="min-w-full divide-y divide-gray-200">
                                        <thead className="bg-gray-50">
                                            <tr>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Photo</th>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Content</th>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                                <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody className="bg-white divide-y divide-gray-200">
                                            {testimonials.map((testimonial) => (
                                                <tr key={testimonial.id}>
                                                    <td className="px-6 py-4 whitespace-nowrap">
                                                        {testimonial.client_photo ? (
                                                            <img
                                                                src={`${testimonial.client_photo.file_path}`}
                                                                alt={testimonial.client_name}
                                                                className="h-10 w-10 rounded-full object-cover"
                                                            />
                                                        ) : (
                                                            <div className="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                                <span className="text-gray-600 text-sm font-medium">
                                                                    {testimonial.client_name.charAt(0)}
                                                                </span>
                                                            </div>
                                                        )}
                                                    </td>
                                                    <td className="px-6 py-4">
                                                        <div className="text-sm font-medium text-gray-900">{testimonial.client_name}</div>
                                                        {testimonial.client_position && (
                                                            <div className="text-sm text-gray-500">{testimonial.client_position}</div>
                                                        )}
                                                        {testimonial.client_company && (
                                                            <div className="text-sm text-gray-500">{testimonial.client_company}</div>
                                                        )}
                                                    </td>
                                                    <td className="px-6 py-4 max-w-md">
                                                        <div className="text-sm text-gray-900 truncate">
                                                            {testimonial.content.substring(0, 100)}...
                                                        </div>
                                                    </td>
                                                    <td className="px-6 py-4 whitespace-nowrap">
                                                        <div className="flex text-lg">
                                                            {renderStars(testimonial.rating)}
                                                        </div>
                                                    </td>
                                                    <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {testimonial.order}
                                                    </td>
                                                    <td className="px-6 py-4 whitespace-nowrap">
                                                        <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${testimonial.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`}>
                                                            {testimonial.is_active ? 'Active' : 'Inactive'}
                                                        </span>
                                                    </td>
                                                    <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                                        <Link
                                                            href={route('admin.testimonials.edit', testimonial.id)}
                                                            className="text-indigo-600 hover:text-indigo-900">
                                                            Edit
                                                        </Link>
                                                        <button
                                                            onClick={() => deleteTestimonial(testimonial.id)}
                                                            className="text-red-600 hover:text-red-900">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
