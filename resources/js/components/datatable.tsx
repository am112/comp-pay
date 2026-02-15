'use client';

import {
    ColumnDef,
    getCoreRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    PaginationState,
    SortingState,
    useReactTable,
} from '@tanstack/react-table';
import { useState } from 'react';

import { DataGrid, DataGridContainer } from './ui/data-grid';
import { DataGridPagination } from './ui/data-grid-pagination';
import { DataGridTable } from './ui/data-grid-table';
import { ScrollArea, ScrollBar } from './ui/scroll-area';

type DatatableProps<T extends object> = {
    data: T[];
    columns: ColumnDef<T, unknown>[];
    sortedKey?: string;
};

export default function Datatable<T extends object>({
    data,
    columns,
    sortedKey,
}: DatatableProps<T>) {
    const [pagination, setPagination] = useState<PaginationState>({
        pageIndex: 0,
        pageSize: 10,
    });

    const [sorting, setSorting] = useState<SortingState>([
        {
            id: sortedKey ?? 'id',
            desc: true,
        },
    ]);

    const [columnOrder, setColumnOrder] = useState<string[]>(
        columns.map((column) => column.id as string),
    );

    const table = useReactTable({
        data,
        columns,
        getCoreRowModel: getCoreRowModel(),
        getSortedRowModel: getSortedRowModel(),
        onSortingChange: setSorting,
        enableSortingRemoval: false,
        getPaginationRowModel: getPaginationRowModel(),
        onPaginationChange: setPagination,
        onColumnOrderChange: setColumnOrder,
        pageCount: Math.ceil((data?.length || 0) / pagination.pageSize),
        getRowId: (row: T) => row.id,
        columnResizeMode: 'onChange',
        state: {
            sorting,
            pagination,
            columnOrder,
        },
    });

    return (
        <DataGrid
            table={table}
            recordCount={data?.length || 0}
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
