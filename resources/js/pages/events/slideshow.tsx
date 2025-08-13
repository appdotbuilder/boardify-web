import React, { useState, useEffect, useCallback } from 'react';
import { Head } from '@inertiajs/react';
import { Heart, Play, Pause, SkipForward, SkipBack } from 'lucide-react';
import { Button } from '@/components/ui/button';

interface Greeting {
    id: number;
    custom_message: string;
    sender_name: string;
    display_duration: number;
    customer: {
        user: {
            name: string;
        };
    };
    template: {
        id: number;
        name: string;
        category: string;
        design_config: {
            background_color: string;
            text_color: string;
            font_family: string;
            font_size: number;
            layout: string;
            animation: string;
        };
    };
}

interface Event {
    id: number;
    name: string;
    location: string;
    event_date: string;
}

interface Props {
    event: Event;
    greetings: Greeting[];
    [key: string]: unknown;
}

export default function EventSlideshow({ event, greetings }: Props) {
    const [currentIndex, setCurrentIndex] = useState(0);
    const [isPlaying, setIsPlaying] = useState(true);
    const [timeLeft, setTimeLeft] = useState(0);
    const [isFullscreen, setIsFullscreen] = useState(false);

    const currentGreeting = greetings[currentIndex];
    const hasGreetings = greetings.length > 0;

    // Initialize timer for current greeting
    useEffect(() => {
        if (currentGreeting && isPlaying) {
            setTimeLeft(currentGreeting.display_duration * 1000);
        }
    }, [currentIndex, currentGreeting, isPlaying]);

    // Auto-advance slideshow
    useEffect(() => {
        if (!hasGreetings || !isPlaying) return;

        const interval = setInterval(() => {
            setTimeLeft((prev) => {
                if (prev <= 100) {
                    // Move to next greeting
                    setCurrentIndex((prevIndex) => 
                        prevIndex === greetings.length - 1 ? 0 : prevIndex + 1
                    );
                    return currentGreeting?.display_duration * 1000 || 5000;
                }
                return prev - 100;
            });
        }, 100);

        return () => clearInterval(interval);
    }, [hasGreetings, isPlaying, greetings.length, currentGreeting?.display_duration]);

    const nextGreeting = useCallback(() => {
        if (!hasGreetings) return;
        setCurrentIndex((prev) => prev === greetings.length - 1 ? 0 : prev + 1);
    }, [hasGreetings, greetings.length]);

    const prevGreeting = useCallback(() => {
        if (!hasGreetings) return;
        setCurrentIndex((prev) => prev === 0 ? greetings.length - 1 : prev - 1);
    }, [hasGreetings, greetings.length]);

    const togglePlayPause = useCallback(() => {
        setIsPlaying(!isPlaying);
    }, [isPlaying]);

    const toggleFullscreen = () => {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
            setIsFullscreen(true);
        } else {
            document.exitFullscreen();
            setIsFullscreen(false);
        }
    };

    // Keyboard controls
    useEffect(() => {
        const handleKeyPress = (event: KeyboardEvent) => {
            switch (event.key) {
                case 'ArrowRight':
                case ' ':
                    event.preventDefault();
                    if (event.key === ' ') togglePlayPause();
                    else nextGreeting();
                    break;
                case 'ArrowLeft':
                    event.preventDefault();
                    prevGreeting();
                    break;
                case 'f':
                case 'F11':
                    event.preventDefault();
                    toggleFullscreen();
                    break;
                case 'Escape':
                    if (isPlaying) setIsPlaying(false);
                    break;
            }
        };

        window.addEventListener('keydown', handleKeyPress);
        return () => window.removeEventListener('keydown', handleKeyPress);
    }, [nextGreeting, prevGreeting, togglePlayPause, isPlaying]);

    // Handle fullscreen change
    useEffect(() => {
        const handleFullscreenChange = () => {
            setIsFullscreen(!!document.fullscreenElement);
        };

        document.addEventListener('fullscreenchange', handleFullscreenChange);
        return () => document.removeEventListener('fullscreenchange', handleFullscreenChange);
    }, []);

    const getAnimationClass = (animation: string) => {
        switch (animation) {
            case 'fade': return 'animate-fade-in';
            case 'slide': return 'animate-slide-in';
            case 'zoom': return 'animate-zoom-in';
            case 'bounce': return 'animate-bounce-in';
            default: return 'animate-fade-in';
        }
    };

    const getTextAlignment = (layout: string) => {
        switch (layout) {
            case 'left': return 'text-left';
            case 'right': return 'text-right';
            case 'center': 
            default: return 'text-center';
        }
    };

    const progressPercentage = currentGreeting 
        ? ((currentGreeting.display_duration * 1000 - timeLeft) / (currentGreeting.display_duration * 1000)) * 100
        : 0;

    if (!hasGreetings) {
        return (
            <>
                <Head title={`${event.name} - No Greetings Yet`} />
                <div className="min-h-screen bg-gradient-to-br from-blue-900 to-indigo-900 flex items-center justify-center p-4">
                    <div className="text-center text-white">
                        <Heart className="w-24 h-24 mx-auto mb-6 text-blue-300" />
                        <h1 className="text-4xl font-bold mb-4">{event.name}</h1>
                        <p className="text-xl text-blue-200 mb-2">📍 {event.location}</p>
                        <p className="text-lg text-blue-300 mb-8">
                            🕒 {new Date(event.event_date).toLocaleDateString()}
                        </p>
                        <div className="bg-white/10 backdrop-blur-sm rounded-lg p-8">
                            <h2 className="text-2xl font-semibold mb-4">No Greetings Yet</h2>
                            <p className="text-blue-200">
                                Greetings will appear here once people start sending them!
                            </p>
                        </div>
                    </div>
                </div>
            </>
        );
    }

    const template = currentGreeting.template;
    const designConfig = template.design_config;

    return (
        <>
            <Head title={`${event.name} - Live Greetings`} />
            
            <div className="min-h-screen relative overflow-hidden">
                {/* Main Display Area */}
                <div 
                    className={`min-h-screen flex items-center justify-center p-8 transition-all duration-1000 ${getAnimationClass(designConfig.animation)}`}
                    style={{ 
                        backgroundColor: designConfig.background_color === 'blue' ? '#1e40af' : 
                                       designConfig.background_color === 'pink' ? '#ec4899' :
                                       designConfig.background_color === 'gold' ? '#f59e0b' :
                                       designConfig.background_color === 'green' ? '#10b981' :
                                       designConfig.background_color === 'purple' ? '#8b5cf6' :
                                       designConfig.background_color === 'red' ? '#ef4444' : '#1e40af',
                        backgroundImage: 'radial-gradient(circle at 50% 50%, rgba(255,255,255,0.1) 0%, transparent 50%)',
                    }}
                >
                    <div className={`max-w-4xl mx-auto ${getTextAlignment(designConfig.layout)}`}>
                        {/* Greeting Card */}
                        <div className="bg-white/95 backdrop-blur-sm rounded-2xl p-12 shadow-2xl border border-white/20">
                            <div className="mb-8">
                                <h1 
                                    className="font-bold leading-tight mb-6"
                                    style={{ 
                                        color: designConfig.text_color === 'white' ? '#1f2937' : designConfig.text_color,
                                        fontFamily: designConfig.font_family,
                                        fontSize: `${Math.max(designConfig.font_size + 8, 28)}px`,
                                    }}
                                >
                                    {currentGreeting.custom_message}
                                </h1>
                                
                                <div className="flex items-center justify-between">
                                    <div>
                                        <p 
                                            className="font-semibold"
                                            style={{ 
                                                color: designConfig.text_color === 'white' ? '#374151' : designConfig.text_color,
                                                fontFamily: designConfig.font_family,
                                                fontSize: `${Math.max(designConfig.font_size - 2, 16)}px`,
                                            }}
                                        >
                                            From: {currentGreeting.sender_name}
                                        </p>
                                        <p className="text-gray-500 text-sm mt-1">
                                            Template: {template.name} • {template.category}
                                        </p>
                                    </div>
                                    <div className="text-right">
                                        <div className="text-2xl mb-1">💝</div>
                                        <p className="text-sm text-gray-500">
                                            {currentGreeting.display_duration}s display
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Event Info */}
                        <div className="mt-8 text-white/90">
                            <h2 className="text-2xl font-bold mb-2">{event.name}</h2>
                            <p className="text-lg">📍 {event.location}</p>
                            <p className="text-lg">🕒 {new Date(event.event_date).toLocaleDateString()}</p>
                        </div>
                    </div>
                </div>

                {/* Progress Bar */}
                <div className="absolute bottom-0 left-0 right-0 h-2 bg-black/20">
                    <div 
                        className="h-full bg-white/80 transition-all duration-100 ease-linear"
                        style={{ width: `${progressPercentage}%` }}
                    />
                </div>

                {/* Controls Overlay */}
                <div className="absolute top-4 right-4 flex items-center space-x-2">
                    <div className="bg-black/50 backdrop-blur-sm rounded-lg px-3 py-2 text-white text-sm">
                        {currentIndex + 1} / {greetings.length}
                    </div>
                    
                    <div className="bg-black/50 backdrop-blur-sm rounded-lg p-2 flex items-center space-x-1">
                        <Button
                            size="sm"
                            variant="ghost"
                            className="text-white hover:bg-white/20 h-8 w-8 p-0"
                            onClick={prevGreeting}
                        >
                            <SkipBack className="w-4 h-4" />
                        </Button>
                        
                        <Button
                            size="sm"
                            variant="ghost"
                            className="text-white hover:bg-white/20 h-8 w-8 p-0"
                            onClick={togglePlayPause}
                        >
                            {isPlaying ? (
                                <Pause className="w-4 h-4" />
                            ) : (
                                <Play className="w-4 h-4" />
                            )}
                        </Button>
                        
                        <Button
                            size="sm"
                            variant="ghost"
                            className="text-white hover:bg-white/20 h-8 w-8 p-0"
                            onClick={nextGreeting}
                        >
                            <SkipForward className="w-4 h-4" />
                        </Button>
                    </div>
                    
                    <Button
                        size="sm"
                        variant="ghost"
                        className="bg-black/50 backdrop-blur-sm text-white hover:bg-white/20 px-3"
                        onClick={toggleFullscreen}
                    >
                        {isFullscreen ? 'Exit Fullscreen' : 'Fullscreen'}
                    </Button>
                </div>

                {/* Keyboard Shortcuts Help */}
                <div className="absolute bottom-4 left-4 bg-black/50 backdrop-blur-sm rounded-lg p-3 text-white text-xs">
                    <p className="font-semibold mb-1">Keyboard Shortcuts:</p>
                    <p>Space: Play/Pause • ← →: Navigate • F: Fullscreen • Esc: Pause</p>
                </div>

                {/* Floating Hearts Animation */}
                <div className="absolute inset-0 pointer-events-none overflow-hidden">
                    {[...Array(6)].map((_, i) => (
                        <div
                            key={i}
                            className="absolute animate-float-heart opacity-30"
                            style={{
                                left: `${Math.random() * 100}%`,
                                animationDelay: `${Math.random() * 10}s`,
                                fontSize: `${Math.random() * 20 + 20}px`,
                            }}
                        >
                            💝
                        </div>
                    ))}
                </div>
            </div>


        </>
    );
}