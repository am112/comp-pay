'use client';

import { router, usePage } from '@inertiajs/react';
import {
    ColumnDef,
    getCoreRowModel,
    PaginationState,
    SortingState,
    useReactTable,
} from '@tanstack/react-table';
import { useEffect, useRef, useState } from 'react';

import { PaginatedData } from '@/types';
import { DataGrid, DataGridContainer } from './ui/data-grid';
import { DataGridPagination } from './ui/data-grid-pagination';
import { DataGridTable } from './ui/data-grid-table';
import { ScrollArea, ScrollBar } from './ui/scroll-area';

type DatatableProps<T extends object> = {
    response: PaginatedData<T>;
    columns: ColumnDef<T, unknown>[];
    routeName: string;
    query?: Record<string, any>;
    sortedKey?: string;
};

export default function DatatableServer<T extends object>({
    response,
    columns,
    routeName,
    query = {},
    sortedKey,
}: DatatableProps<T>) {
    const [pagination, setPagination] = useState<PaginationState>({
        pageIndex: response.current_page - 1,
        pageSize: response.per_page,
    });

    const [sorting, setSorting] = useState<SortingState>([
        {
            id: sortedKey ?? 'id',
            desc: true,
        },
    ]);

    const { url } = usePage();
    const [searchParams, setSearchParams] = useState<Record<string, string>>(
        {},
    );

    // On mount, parse once from Inertia's current URL
    useEffect(() => {
        const queryString = url.split('?')[1] || '';
        const params = new URLSearchParams(queryString);
        const obj: Record<string, string> = {};
        for (const [key, value] of params.entries()) obj[key] = value;
        setSearchParams(obj);
    }, [url]);

    // ---- Prevent refetch on initial render ----
    const isFirstRender = useRef(true);

    // 🔥 React to pagination & sorting changes
    useEffect(() => {
        if (isFirstRender.current) {
            isFirstRender.current = false;
            return; // ✅ Skip first render to avoid redundant GET
        }

        const sortKey = sorting[0]?.id ?? 'id';
        const sortParam = sorting[0]?.desc ? `-${sortKey}` : sortKey;

        router.visit(routeName, {
            data: {
                ...searchParams,
                page: pagination.pageIndex + 1,
                per_page: pagination.pageSize,
                sort: sortParam, // ✅ follows Spatie style
            },
            preserveState: true,
            replace: true,
        });
    }, [pagination, sorting]);

    const table = useReactTable({
        data: response.data,
        columns,
        manualPagination: true,
        manualSorting: true,
        pageCount: Math.ceil(response.total / pagination.pageSize),
        getCoreRowModel: getCoreRowModel(),
        state: {
            sorting,
            pagination,
        },
        onPaginationChange: setPagination,
        onSortingChange: setSorting,
    });

    return (
        <DataGrid
            table={table}
            recordCount={response.total}
            tableLayout={{
                headerBackground: true,
                rowBorder: true,
                rowRounded: false,
                columnsResizable: true,
                columnsVisibility: true,
                columnsPinnable: true,
                columnsMovable: false,
            }}
        >
            <div className="w-full space-y-2.5">
                <DataGridContainer>
                    <ScrollArea>
                        <DataGridTable />
                        <ScrollBar orientation="horizontal" />
                    </ScrollArea>
                </DataGridContainer>
                <DataGridPagination />
            </div>
        </DataGrid>
    );
}
