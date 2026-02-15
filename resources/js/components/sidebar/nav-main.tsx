import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { MenuItem } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import * as Icons from 'lucide-react';
import { LucideProps } from 'lucide-react';

function getLucideIcon(
    name: string | null | undefined,
): React.FC<LucideProps> | null {
    if (name === null || name === undefined) {
        return null;
    }
    const icons = Icons as unknown as Record<string, React.FC<LucideProps>>;
    return icons[name] || null;
}

export function NavMain({
    title = '',
    items = [],
}: {
    title: string;
    items: MenuItem[];
}) {
    const page = usePage();
    return (
        <SidebarGroup className="px-2 py-0">
            {title && <SidebarGroupLabel>{title}</SidebarGroupLabel>}
            <SidebarMenu>
                {items.map((item) => {
                    const LucideIcon = getLucideIcon(item.icon);

                    return (
                        <SidebarMenuItem key={item.title}>
                            <SidebarMenuButton
                                asChild
                                isActive={page.url.startsWith(item.link)}
                                tooltip={{ children: item.title }}
                            >
                                <Link href={item.link} prefetch>
                                    {LucideIcon && (
                                        <LucideIcon className="mr-2 h-4 w-4" />
                                    )}
                                    <span>{item.title}</span>
                                </Link>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    );
                })}
            </SidebarMenu>
        </SidebarGroup>
    );
}
