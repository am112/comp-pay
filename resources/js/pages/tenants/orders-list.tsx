import Datatable from '@/components/datatable';
import { DataGridColumnHeader } from '@/components/ui/data-grid-column-header';
import AppLayout from '@/layouts/app-layout';
import { dashboard as tenantDashboardRoute } from '@/routes/tenants';
import { Order, Tenant, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { ColumnDef } from '@tanstack/react-table';

const columns: ColumnDef<Order>[] = [
    {
        accessorKey: 'reference_no',
        header: ({ column }) => (
            <DataGridColumnHeader
                title="Reference No"
                column={column}
                visibility={true}
            />
        ),
        cell: ({ row }) => (
            <div className="py-2 font-medium">
                {row.getValue('reference_no')}
            </div>
        ),
        size: 180,
        enableSorting: true,
        enableHiding: false,
    },
    {
        header: ({ column }) => (
            <DataGridColumnHeader title="Provider No" column={column} />
        ),
        accessorKey: 'provider_no',
        cell: ({ row }) => (
            <div className="font-medium">{row.getValue('provider_no')}</div>
        ),
        size: 180,
        enableSorting: true,
        enableHiding: true,
    },
    {
        header: ({ column }) => (
            <DataGridColumnHeader title="Status" column={column} />
        ),
        accessorKey: 'status',
        size: 60,
        enableSorting: true,
        enableHiding: true,
    },
    {
        header: ({ column }) => (
            <DataGridColumnHeader title="Amount" column={column} />
        ),
        accessorKey: 'amount',
        cell: ({ row }) => <div>{row.getValue('amount')}</div>,
        size: 60,
        enableSorting: true,
        enableHiding: true,
    },
    {
        header: ({ column }) => (
            <DataGridColumnHeader title="Created At" column={column} />
        ),
        accessorKey: 'created_at',
        cell: ({ row }) => <div>{row.getValue('created_at')}</div>,
        size: 100,
        enableSorting: true,
        enableHiding: true,
    },
    {
        accessorKey: 'id',
        header: () => <span className="sr-only">Actions</span>,
        cell: ({ row }) => <div>{row.original.id}</div>,
        size: 60,
        enableHiding: false,
    },
];

export default function ListOrder({
    orders,
    tenant,
}: {
    orders: Order[];
    tenant: Tenant;
}) {
    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Dashboard',
            href: '/dashboard',
        },
        {
            title: tenant.label,
            href: tenantDashboardRoute({ id: tenant.id }).url,
        },
        {
            title: 'Orders',
            href: '/',
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="text-xl font-semibold">Orders</div>

                <Datatable
                    data={orders}
                    columns={columns}
                    sortedKey={'created_at'}
                />
            </div>
        </AppLayout>
    );
}
