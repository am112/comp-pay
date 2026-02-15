import Datatable from '@/components/datatable';
import { Button } from '@/components/ui/button';
import { DataGridColumnHeader } from '@/components/ui/data-grid-column-header';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { dashboard as tenantDashboardRoute } from '@/routes/tenants';
import { create, edit } from '@/routes/tenants/applications';
import { Integration, Tenant, type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { ColumnDef, Row } from '@tanstack/react-table';
import { EllipsisVertical } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';
import { toast } from 'sonner';
import ViewIntegration from './components/view-integration';

export default function IntegrationsList({
    integrations,
    tenant,
    flash,
}: {
    integrations: Integration[];
    tenant: Tenant;
    flash: { message: string };
}) {
    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Dashboard',
            href: dashboard().url,
        },
        {
            title: tenant.label,
            href: tenantDashboardRoute({ id: tenant.id }).url,
        },
        {
            title: 'Applications',
            href: '/',
        },
    ];

    const columns: ColumnDef<Integration>[] = [
        {
            accessorKey: 'name',
            header: ({ column }) => (
                <DataGridColumnHeader
                    title="Name"
                    column={column}
                    visibility={true}
                />
            ),
            cell: ({ row }) => (
                <div className="py-2 font-medium">{row.getValue('name')}</div>
            ),
            size: 180,
            enableSorting: true,
            enableHiding: false,
        },
        {
            header: ({ column }) => (
                <DataGridColumnHeader title="Driver" column={column} />
            ),
            accessorKey: 'driver',
            cell: ({ row }) => (
                <div className="font-medium">{row.getValue('driver')}</div>
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
            cell: ({ row }) => <ActionsCell row={row} />,
            size: 30,
            enableHiding: false,
        },
    ];

    const [selectedIntegration, setSelectedIntegration] =
        useState<Integration | null>(null);
    const [open, setOpen] = useState(false);
    const hasToasted = useRef(false);

    useEffect(() => {
        if (!hasToasted.current && flash?.message?.trim()) {
            toast(flash.message);
            hasToasted.current = true;
        }
    }, [flash?.message]);

    function ActionsCell({ row }: { row: Row<Integration> }) {
        return (
            <DropdownMenu>
                <DropdownMenuTrigger asChild>
                    <Button className="size-7" mode="icon" variant="ghost">
                        <EllipsisVertical />
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent side="bottom" align="end">
                    <DropdownMenuItem
                        onClick={() => {
                            setSelectedIntegration(row.original);
                            setOpen(true);
                        }}
                    >
                        View
                    </DropdownMenuItem>
                    <DropdownMenuItem>
                        <Link
                            className="w-full"
                            href={edit({
                                tenant: row.original.tenant_id,
                                application: row.original.id,
                            })}
                        >
                            Edit
                        </Link>
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        );
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="text-xl font-semibold">Applications</div>
                <div className="text-right">
                    <Button>
                        <Link href={create({ tenant: tenant.id })}>Create</Link>
                    </Button>
                </div>

                <Datatable
                    data={integrations}
                    columns={columns}
                    sortedKey={'created_at'}
                />
                <ViewIntegration
                    open={open}
                    onOpenChange={setOpen}
                    integration={selectedIntegration}
                />
            </div>
        </AppLayout>
    );
}
