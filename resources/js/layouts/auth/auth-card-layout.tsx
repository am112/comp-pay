import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { HoverBackground } from '@/components/ui/hover-background';
import { type PropsWithChildren } from 'react';

export default function AuthCardLayout({
    children,
    title,
    description,
}: PropsWithChildren<{
    name?: string;
    title?: string;
    description?: string;
}>) {
    return (
        <HoverBackground
            colors={{
                background:
                    'bg-gradient-to-br from-black via-green-700 to-zinc-900 dark:bg-gradient-to-br dark:from-black dark:via-gray-900 dark:to-zinc-900',
                objects: [
                    'bg-emerald-500/30',
                    'bg-yellow-500/30',
                    'bg-blue-500/30',
                    'bg-lime-500/30',
                    'bg-cyan-500/30',
                    'bg-blue-500/30',
                ],
                glow: 'shadow-emerald-400/70',
            }}
            objectCount={8}
        >
            <div className="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
                <div className="flex w-full max-w-md flex-col gap-6">
                    <div className="flex flex-col gap-6">
                        <Card variant="accent" className="rounded-xl">
                            <CardHeader className="min-w-full px-10 py-2">
                                <CardTitle className="min-w-full items-center text-center text-xl">
                                    {title}
                                </CardTitle>
                                <CardDescription className="min-w-full items-center text-center">
                                    {description}
                                </CardDescription>
                            </CardHeader>
                            <CardContent className="px-10 py-8">
                                {children}
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </HoverBackground>
    );
}
