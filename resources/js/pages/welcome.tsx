import { Button } from '@/components/ui/button';
import { HoverBackground } from '@/components/ui/hover-background';
import { login } from '@/routes';
import { Head, Link } from '@inertiajs/react';

export default function Welcome() {
    return (
        <>
            <Head title="Welcome">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link
                    href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600"
                    rel="stylesheet"
                />
            </Head>
            <HoverBackground
                colors={{
                    background:
                        'bg-gradient-to-br from-black via-green-700 to-zinc-900 dark:bg-gradient-to-br dark:from-black dark:via-gray-900 dark:to-zinc-900',
                    objects: [
                        'bg-emerald-500/30',
                        'bg-teal-500/30',
                        'bg-green-500/30',
                        'bg-lime-500/30',
                        'bg-cyan-500/30',
                        'bg-blue-500/30',
                    ],
                    glow: 'shadow-emerald-400/70',
                }}
                objectCount={8}
            >
                <div className="flex h-screen items-center justify-center">
                    <div className="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
                        <div className="space-y-4 text-center">
                            <h2 className="text-4xl font-bold text-white/90">
                                Your Payment Gateway
                            </h2>
                            <p className="max-w-md text-lg text-emerald-100/80">
                                A sophisticated payment gateway for your
                                applications.
                            </p>
                            <Link href={login()}>
                                <Button className="px-8">Get Started</Button>
                            </Link>
                        </div>
                    </div>
                </div>
            </HoverBackground>
        </>
    );
}
