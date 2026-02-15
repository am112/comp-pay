import { InertiaLinkProps } from '@inertiajs/react';
import { LucideIcon } from 'lucide-react';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface ItemData {
    label: string;
    value: string;
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
    menu: Menu[];
    [key: string]: unknown;
    tenants: Tenant[];
}

export interface Menu {
    title: string;
    items: MenuItem[];
}

export interface MenuItem {
    title: string;
    link: string;
    icon?: string | null;
    isActive?: boolean;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    two_factor_enabled?: boolean;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface Tenant {
    id: string;
    code: string;
    label: string;
    created_at: string;
    updated_at: string;
}

export type PaginatedData<T> = {
    data: T[];
    current_page: number;
    total: number;
    per_page: number;
};

export interface Integration {
    id: number;
    tenant_id: string;
    name: string;
    status: string;
    driver: string;
    redirect_consent?: string;
    redirect_collection?: string;
    webhook_consent?: string;
    webhook_collection?: string;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface Order {
    id: number;
    tenant_id: string;
    reference_no: string;
    provider_no: string;
    status: string;
    amount: number;
    total_amount: number;
    paid_amount: number;
    driver: string;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface Invoice {
    id: number;
    tenant_id: string;
    order_id: number;
    type: string;
    collection_no: string;
    reference_no: string;
    provider_no: string;
    status: string;
    amount: number;
    currency: string;
    response_at: string;
    driver: string;
    batch: string;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}
