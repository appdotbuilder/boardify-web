import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Calendar, Heart, Star, ArrowRight, Clock, Zap } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';

interface Event {
    id: number;
    name: string;
    location: string;
    event_date: string;
    partner: {
        user: {
            name: string;
        };
    };
    greetings_count?: number;
}

interface Template {
    id: number;
    name: string;
    category: string;
    preview_image: string;
    description: string;
}

interface Props {
    activeEvents: Event[];
    featuredTemplates: Template[];
    stats: {
        totalEvents: number;
        totalTemplates: number;
        activeGreetings: number;
    };
    auth?: {
        user?: {
            name: string;
            email: string;
        };
    };
    [key: string]: unknown;
}

export default function BoardifyIndex({ activeEvents, featuredTemplates, stats, auth }: Props) {
    return (
        <>
            <Head title="Boardify - Digital Greetings for Every Event" />
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
                {/* Navigation */}
                <nav className="bg-white/80 backdrop-blur-md border-b border-blue-200 sticky top-0 z-50">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center h-16">
                            <div className="flex items-center space-x-2">
                                <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <Heart className="w-5 h-5 text-white" />
                                </div>
                                <span className="text-xl font-bold text-blue-900">Boardify</span>
                            </div>
                            
                            <div className="hidden md:flex items-center space-x-6">
                                <Link href="/events" className="text-blue-700 hover:text-blue-900 font-medium transition-colors">
                                    Events
                                </Link>
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

                {/* Hero Section */}
                <section className="relative py-20 px-4 sm:px-6 lg:px-8">
                    <div className="max-w-7xl mx-auto text-center">
                        <div className="mb-8 animate-fade-in">
                            <h1 className="text-5xl md:text-6xl font-bold text-blue-900 mb-6">
                                🎉 Digital Greetings
                                <br />
                                <span className="text-blue-600">for Every Event</span>
                            </h1>
                            <p className="text-xl text-blue-700 max-w-3xl mx-auto leading-relaxed">
                                Create beautiful, personalized greeting cards that display during live events. 
                                From weddings to conferences, make your message shine on the big screen! ✨
                            </p>
                        </div>
                        
                        <div className="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                            <Link href="/events">
                                <Button size="lg" className="bg-blue-600 hover:bg-blue-700 text-lg px-8 py-4">
                                    Browse Events
                                    <ArrowRight className="ml-2 w-5 h-5" />
                                </Button>
                            </Link>
                            <Link href="/templates">
                                <Button size="lg" variant="outline" className="border-blue-300 text-blue-700 hover:bg-blue-50 text-lg px-8 py-4">
                                    View Templates
                                    <Star className="ml-2 w-5 h-5" />
                                </Button>
                            </Link>
                        </div>

                        {/* Stats */}
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-3xl mx-auto">
                            <div className="bg-white/60 backdrop-blur-sm rounded-xl p-6 border border-blue-200">
                                <div className="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-4">
                                    <Calendar className="w-6 h-6 text-blue-600" />
                                </div>
                                <div className="text-3xl font-bold text-blue-900 mb-1">{stats.totalEvents}</div>
                                <div className="text-blue-600">Active Events</div>
                            </div>
                            <div className="bg-white/60 backdrop-blur-sm rounded-xl p-6 border border-blue-200">
                                <div className="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-4">
                                    <Star className="w-6 h-6 text-blue-600" />
                                </div>
                                <div className="text-3xl font-bold text-blue-900 mb-1">{stats.totalTemplates}</div>
                                <div className="text-blue-600">Beautiful Templates</div>
                            </div>
                            <div className="bg-white/60 backdrop-blur-sm rounded-xl p-6 border border-blue-200">
                                <div className="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-4">
                                    <Heart className="w-6 h-6 text-blue-600" />
                                </div>
                                <div className="text-3xl font-bold text-blue-900 mb-1">{stats.activeGreetings}</div>
                                <div className="text-blue-600">Greetings Sent</div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* How It Works */}
                <section className="py-16 px-4 sm:px-6 lg:px-8 bg-white/50 backdrop-blur-sm">
                    <div className="max-w-7xl mx-auto">
                        <div className="text-center mb-12">
                            <h2 className="text-3xl font-bold text-blue-900 mb-4">How Boardify Works</h2>
                            <p className="text-blue-700 text-lg max-w-2xl mx-auto">
                                Send your heartfelt messages in just three simple steps
                            </p>
                        </div>
                        
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div className="text-center">
                                <div className="flex items-center justify-center w-16 h-16 bg-blue-600 rounded-full mx-auto mb-6">
                                    <Calendar className="w-8 h-8 text-white" />
                                </div>
                                <h3 className="text-xl font-semibold text-blue-900 mb-3">1. Choose an Event</h3>
                                <p className="text-blue-700">
                                    Browse active events like weddings, birthdays, or corporate gatherings
                                </p>
                            </div>
                            <div className="text-center">
                                <div className="flex items-center justify-center w-16 h-16 bg-blue-600 rounded-full mx-auto mb-6">
                                    <Star className="w-8 h-8 text-white" />
                                </div>
                                <h3 className="text-xl font-semibold text-blue-900 mb-3">2. Customize Your Card</h3>
                                <p className="text-blue-700">
                                    Select a beautiful template and write your personalized message
                                </p>
                            </div>
                            <div className="text-center">
                                <div className="flex items-center justify-center w-16 h-16 bg-blue-600 rounded-full mx-auto mb-6">
                                    <Zap className="w-8 h-8 text-white" />
                                </div>
                                <h3 className="text-xl font-semibold text-blue-900 mb-3">3. Go Live!</h3>
                                <p className="text-blue-700">
                                    Your greeting displays during the event for everyone to see and enjoy
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Active Events */}
                {activeEvents.length > 0 && (
                    <section className="py-16 px-4 sm:px-6 lg:px-8">
                        <div className="max-w-7xl mx-auto">
                            <div className="flex items-center justify-between mb-12">
                                <div>
                                    <h2 className="text-3xl font-bold text-blue-900 mb-2">🎊 Active Events</h2>
                                    <p className="text-blue-700">Join these live events and send your greetings!</p>
                                </div>
                                <Link href="/events">
                                    <Button variant="outline" className="border-blue-300 text-blue-700 hover:bg-blue-50">
                                        View All Events
                                        <ArrowRight className="ml-2 w-4 h-4" />
                                    </Button>
                                </Link>
                            </div>
                            
                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                {activeEvents.slice(0, 6).map((event) => (
                                    <Card key={event.id} className="bg-white/80 backdrop-blur-sm border-blue-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                                        <CardHeader>
                                            <CardTitle className="text-blue-900 flex items-center gap-2">
                                                <Calendar className="w-5 h-5 text-blue-600" />
                                                {event.name}
                                            </CardTitle>
                                            <CardDescription className="text-blue-600">
                                                by {event.partner.user.name}
                                            </CardDescription>
                                        </CardHeader>
                                        <CardContent>
                                            <div className="space-y-2 mb-4">
                                                <p className="text-blue-700 flex items-center gap-2">
                                                    <span>📍</span>
                                                    {event.location}
                                                </p>
                                                <p className="text-blue-700 flex items-center gap-2">
                                                    <Clock className="w-4 h-4" />
                                                    {new Date(event.event_date).toLocaleDateString()}
                                                </p>
                                            </div>
                                            <Link href={auth?.user ? `/events/${event.id}/greetings/create` : '/register'}>
                                                <Button className="w-full bg-blue-600 hover:bg-blue-700">
                                                    Send Greeting 💝
                                                </Button>
                                            </Link>
                                        </CardContent>
                                    </Card>
                                ))}
                            </div>
                        </div>
                    </section>
                )}

                {/* Featured Templates */}
                <section className="py-16 px-4 sm:px-6 lg:px-8 bg-white/30 backdrop-blur-sm">
                    <div className="max-w-7xl mx-auto">
                        <div className="text-center mb-12">
                            <h2 className="text-3xl font-bold text-blue-900 mb-4">🎨 Beautiful Templates</h2>
                            <p className="text-blue-700 text-lg max-w-2xl mx-auto">
                                Choose from our collection of stunning greeting card designs
                            </p>
                        </div>
                        
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
                            {featuredTemplates.slice(0, 8).map((template) => (
                                <div key={template.id} className="bg-white/80 backdrop-blur-sm rounded-lg border border-blue-200 p-4 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                                    <div className="aspect-video bg-gradient-to-br from-blue-100 to-indigo-200 rounded-lg mb-3 flex items-center justify-center">
                                        <Star className="w-8 h-8 text-blue-600" />
                                    </div>
                                    <h3 className="font-semibold text-blue-900 text-sm mb-1">{template.name}</h3>
                                    <Badge variant="secondary" className="text-xs bg-blue-100 text-blue-700">
                                        {template.category}
                                    </Badge>
                                </div>
                            ))}
                        </div>
                        
                        <div className="text-center mt-8">
                            <Link href="/templates">
                                <Button variant="outline" className="border-blue-300 text-blue-700 hover:bg-blue-50">
                                    Browse All Templates
                                    <ArrowRight className="ml-2 w-4 h-4" />
                                </Button>
                            </Link>
                        </div>
                    </div>
                </section>

                {/* Pricing */}
                <section className="py-16 px-4 sm:px-6 lg:px-8">
                    <div className="max-w-4xl mx-auto text-center">
                        <h2 className="text-3xl font-bold text-blue-900 mb-4">💎 Simple Pricing</h2>
                        <p className="text-blue-700 text-lg mb-12">Choose how long your greeting displays</p>
                        
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div className="bg-white/80 backdrop-blur-sm rounded-xl p-6 border border-blue-200">
                                <Clock className="w-8 h-8 text-blue-600 mx-auto mb-4" />
                                <h3 className="text-xl font-bold text-blue-900 mb-2">3 Seconds</h3>
                                <div className="text-3xl font-bold text-blue-600 mb-2">IDR 7,500</div>
                                <p className="text-blue-700 text-sm">Perfect for quick messages</p>
                            </div>
                            <div className="bg-white/80 backdrop-blur-sm rounded-xl p-6 border-2 border-blue-400 relative">
                                <Badge className="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-blue-600">Popular</Badge>
                                <Clock className="w-8 h-8 text-blue-600 mx-auto mb-4" />
                                <h3 className="text-xl font-bold text-blue-900 mb-2">5 Seconds</h3>
                                <div className="text-3xl font-bold text-blue-600 mb-2">IDR 12,500</div>
                                <p className="text-blue-700 text-sm">Ideal for most greetings</p>
                            </div>
                            <div className="bg-white/80 backdrop-blur-sm rounded-xl p-6 border border-blue-200">
                                <Clock className="w-8 h-8 text-blue-600 mx-auto mb-4" />
                                <h3 className="text-xl font-bold text-blue-900 mb-2">7 Seconds</h3>
                                <div className="text-3xl font-bold text-blue-600 mb-2">IDR 17,500</div>
                                <p className="text-blue-700 text-sm">For longer, heartfelt messages</p>
                            </div>
                        </div>
                    </div>
                </section>

                {/* CTA Section */}
                <section className="py-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-blue-600 to-indigo-600">
                    <div className="max-w-4xl mx-auto text-center">
                        <h2 className="text-3xl font-bold text-white mb-4">
                            Ready to Share Your Message? 🚀
                        </h2>
                        <p className="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
                            Join thousands of people who have shared their heartfelt messages through Boardify. 
                            Your greeting could be the highlight of someone's special day!
                        </p>
                        
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            {auth?.user ? (
                                <Link href="/events">
                                    <Button size="lg" className="bg-white text-blue-600 hover:bg-blue-50 text-lg px-8 py-4">
                                        Browse Events
                                        <ArrowRight className="ml-2 w-5 h-5" />
                                    </Button>
                                </Link>
                            ) : (
                                <>
                                    <Link href="/register">
                                        <Button size="lg" className="bg-white text-blue-600 hover:bg-blue-50 text-lg px-8 py-4">
                                            Get Started Free
                                            <ArrowRight className="ml-2 w-5 h-5" />
                                        </Button>
                                    </Link>
                                    <Link href="/login">
                                        <Button size="lg" variant="outline" className="border-white text-white hover:bg-white/10 text-lg px-8 py-4">
                                            Sign In
                                        </Button>
                                    </Link>
                                </>
                            )}
                        </div>
                    </div>
                </section>

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
                            <Link href="/events" className="text-blue-700 hover:text-blue-900">Events</Link>
                            <Link href="/templates" className="text-blue-700 hover:text-blue-900">Templates</Link>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}