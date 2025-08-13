import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Calendar, MapPin, Clock, Users, Heart, ArrowRight } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';

interface Event {
    id: number;
    name: string;
    description?: string;
    location: string;
    event_date: string;
    registration_start: string;
    registration_end: string;
    partner: {
        user: {
            name: string;
        };
    };
    greetings_count?: number;
}

interface Props {
    events: {
        data: Event[];
        links: Array<{
            url: string | null;
            label: string;
            active: boolean;
        }>;
        meta: {
            current_page: number;
            total: number;
            per_page: number;
        };
    };
    auth?: {
        user?: {
            name: string;
            email: string;
        };
    };
    [key: string]: unknown;
}

export default function EventsPage({ events, auth }: Props) {
    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    };

    const isRegistrationOpen = (event: Event) => {
        const now = new Date();
        const start = new Date(event.registration_start);
        const end = new Date(event.registration_end);
        return now >= start && now <= end;
    };

    return (
        <>
            <Head title="Active Events - Boardify" />
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
                {/* Navigation */}
                <nav className="bg-white/80 backdrop-blur-md border-b border-blue-200 sticky top-0 z-50">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center h-16">
                            <Link href="/" className="flex items-center space-x-2">
                                <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <Heart className="w-5 h-5 text-white" />
                                </div>
                                <span className="text-xl font-bold text-blue-900">Boardify</span>
                            </Link>
                            
                            <div className="hidden md:flex items-center space-x-6">
                                <Link href="/" className="text-blue-700 hover:text-blue-900 font-medium transition-colors">
                                    Home
                                </Link>
                                <span className="text-blue-900 font-medium">Events</span>
                                <Link href="/templates" className="text-blue-700 hover:text-blue-900 font-medium transition-colors">
                                    Templates
                                </Link>
                            </div>
                            
                            <div className="flex items-center space-x-3">
                                {auth?.user ? (
                                    <div className="flex items-center space-x-3">
                                        <span className="text-blue-700 font-medium">Hi, {auth.user.name}!</span>
                                        <Link href="/dashboard">
                                            <Button className="bg-blue-600 hover:bg-blue-700">Dashboard</Button>
                                        </Link>
                                    </div>
                                ) : (
                                    <>
                                        <Link href="/login">
                                            <Button variant="outline" className="border-blue-300 text-blue-700 hover:bg-blue-50">
                                                Login
                                            </Button>
                                        </Link>
                                        <Link href="/register">
                                            <Button className="bg-blue-600 hover:bg-blue-700">
                                                Get Started
                                            </Button>
                                        </Link>
                                    </>
                                )}
                            </div>
                        </div>
                    </div>
                </nav>

                {/* Header */}
                <section className="py-16 px-4 sm:px-6 lg:px-8">
                    <div className="max-w-7xl mx-auto text-center">
                        <h1 className="text-4xl md:text-5xl font-bold text-blue-900 mb-6">
                            🎊 Active Events
                        </h1>
                        <p className="text-xl text-blue-700 max-w-2xl mx-auto">
                            Join these exciting events and share your heartfelt greetings with everyone!
                        </p>
                    </div>
                </section>

                {/* Events Grid */}
                <section className="pb-16 px-4 sm:px-6 lg:px-8">
                    <div className="max-w-7xl mx-auto">
                        {events.data.length === 0 ? (
                            <div className="text-center py-16">
                                <Calendar className="w-24 h-24 text-blue-400 mx-auto mb-6" />
                                <h3 className="text-2xl font-bold text-blue-900 mb-4">No Active Events</h3>
                                <p className="text-blue-700 mb-8">
                                    There are no events currently accepting greetings. Check back soon!
                                </p>
                                <Link href="/">
                                    <Button className="bg-blue-600 hover:bg-blue-700">
                                        Back to Home
                                    </Button>
                                </Link>
                            </div>
                        ) : (
                            <>
                                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                    {events.data.map((event) => (
                                        <Card key={event.id} className="bg-white/80 backdrop-blur-sm border-blue-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                                            <CardHeader className="pb-4">
                                                <div className="flex items-start justify-between">
                                                    <div className="flex-1">
                                                        <CardTitle className="text-blue-900 text-lg mb-2 leading-tight">
                                                            {event.name}
                                                        </CardTitle>
                                                        <CardDescription className="text-blue-600">
                                                            Organized by {event.partner.user.name}
                                                        </CardDescription>
                                                    </div>
                                                    {isRegistrationOpen(event) ? (
                                                        <Badge className="bg-green-100 text-green-800 border-green-300">
                                                            Open
                                                        </Badge>
                                                    ) : (
                                                        <Badge variant="secondary" className="bg-gray-100 text-gray-800">
                                                            Closed
                                                        </Badge>
                                                    )}
                                                </div>
                                            </CardHeader>
                                            <CardContent className="space-y-4">
                                                {event.description && (
                                                    <p className="text-blue-700 text-sm line-clamp-2">
                                                        {event.description}
                                                    </p>
                                                )}
                                                
                                                <div className="space-y-3">
                                                    <div className="flex items-center gap-2 text-blue-700">
                                                        <MapPin className="w-4 h-4 text-blue-600 flex-shrink-0" />
                                                        <span className="text-sm truncate">{event.location}</span>
                                                    </div>
                                                    
                                                    <div className="flex items-center gap-2 text-blue-700">
                                                        <Calendar className="w-4 h-4 text-blue-600 flex-shrink-0" />
                                                        <span className="text-sm">{formatDate(event.event_date)}</span>
                                                    </div>
                                                    
                                                    <div className="flex items-center gap-2 text-blue-700">
                                                        <Clock className="w-4 h-4 text-blue-600 flex-shrink-0" />
                                                        <span className="text-sm">
                                                            Registration until {formatDate(event.registration_end)}
                                                        </span>
                                                    </div>
                                                    
                                                    {event.greetings_count !== undefined && (
                                                        <div className="flex items-center gap-2 text-blue-700">
                                                            <Users className="w-4 h-4 text-blue-600 flex-shrink-0" />
                                                            <span className="text-sm">
                                                                {event.greetings_count} greeting{event.greetings_count !== 1 ? 's' : ''} sent
                                                            </span>
                                                        </div>
                                                    )}
                                                </div>
                                                
                                                <div className="pt-4 space-y-2">
                                                    {isRegistrationOpen(event) ? (
                                                        <Link href={auth?.user ? `/events/${event.id}/greetings/create` : '/register'}>
                                                            <Button className="w-full bg-blue-600 hover:bg-blue-700">
                                                                Send Greeting 💝
                                                                <ArrowRight className="ml-2 w-4 h-4" />
                                                            </Button>
                                                        </Link>
                                                    ) : (
                                                        <Button disabled className="w-full">
                                                            Registration Closed
                                                        </Button>
                                                    )}
                                                    
                                                    <Link href={`/events/${event.id}/slideshow`}>
                                                        <Button variant="outline" className="w-full border-blue-300 text-blue-700 hover:bg-blue-50">
                                                            View Slideshow 🎬
                                                        </Button>
                                                    </Link>
                                                </div>
                                            </CardContent>
                                        </Card>
                                    ))}
                                </div>

                                {/* Pagination */}
                                {events.meta.total > events.meta.per_page && (
                                    <div className="flex justify-center mt-12">
                                        <div className="flex items-center space-x-2">
                                            {events.links.map((link, index) => (
                                                link.url ? (
                                                    <Link
                                                        key={index}
                                                        href={link.url}
                                                        className={`px-4 py-2 rounded-md text-sm font-medium transition-colors ${
                                                            link.active
                                                                ? 'bg-blue-600 text-white'
                                                                : 'bg-white/80 text-blue-700 hover:bg-blue-50 border border-blue-200'
                                                        }`}
                                                        dangerouslySetInnerHTML={{ __html: link.label }}
                                                    />
                                                ) : (
                                                    <span
                                                        key={index}
                                                        className="px-4 py-2 rounded-md text-sm font-medium text-gray-400 bg-white/50"
                                                        dangerouslySetInnerHTML={{ __html: link.label }}
                                                    />
                                                )
                                            ))}
                                        </div>
                                    </div>
                                )}
                            </>
                        )}
                    </div>
                </section>

                {/* CTA Section */}
                {events.data.length > 0 && (
                    <section className="py-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-blue-600 to-indigo-600">
                        <div className="max-w-4xl mx-auto text-center">
                            <h2 className="text-3xl font-bold text-white mb-4">
                                Want to Host Your Own Event? 🎪
                            </h2>
                            <p className="text-blue-100 text-lg mb-8">
                                Request to hold your own event and let people send beautiful greetings!
                            </p>
                            
                            {auth?.user ? (
                                <Link href="/dashboard">
                                    <Button size="lg" className="bg-white text-blue-600 hover:bg-blue-50 text-lg px-8 py-4">
                                        Request Event
                                        <ArrowRight className="ml-2 w-5 h-5" />
                                    </Button>
                                </Link>
                            ) : (
                                <Link href="/register">
                                    <Button size="lg" className="bg-white text-blue-600 hover:bg-blue-50 text-lg px-8 py-4">
                                        Get Started
                                        <ArrowRight className="ml-2 w-5 h-5" />
                                    </Button>
                                </Link>
                            )}
                        </div>
                    </section>
                )}

                {/* Footer */}
                <footer className="bg-white/80 backdrop-blur-sm border-t border-blue-200 py-12">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                        <div className="flex items-center justify-center space-x-2 mb-4">
                            <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                <Heart className="w-5 h-5 text-white" />
                            </div>
                            <span className="text-xl font-bold text-blue-900">Boardify</span>
                        </div>
                        <p className="text-blue-600 mb-4">Making every event more memorable with digital greetings</p>
                        <div className="flex justify-center space-x-6 text-sm">
                            <Link href="/" className="text-blue-700 hover:text-blue-900">Home</Link>
                            <Link href="/templates" className="text-blue-700 hover:text-blue-900">Templates</Link>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}