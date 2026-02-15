import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import {
    applications as tenantApplicationRoute,
    dashboard as tenantDashboardRoute,
} from '@/routes/tenants';
import { store } from '@/routes/tenants/applications';
import { type BreadcrumbItem, Tenant } from '@/types';
import { Form, Head } from '@inertiajs/react';

interface PageProps {
    tenant: Tenant;
    drivers: { label: string; value: string }[];
    authenticationKey: string;
}

export default function IntegrationsCreate({
    tenant,
    drivers,
    authenticationKey,
}: PageProps) {
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
            href: tenantApplicationRoute({ id: tenant.id }).url,
        },
        {
            title: 'Create',
            href: '/',
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create Application" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card className="w-full">
                    <CardHeader>
                        <CardTitle className="text-xl font-semibold">
                            New Application
                        </CardTitle>
                    </CardHeader>

                    <Form {...store.form({ tenant: tenant })}>
                        {({ processing, errors }) => (
                            <div>
                                <CardContent className="space-y-8">
                                    {/* Name */}

                                    {/* Row: Status + Driver */}
                                    <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                        {/* Name */}
                                        <div className="flex flex-col gap-2">
                                            <Label>Name</Label>
                                            <Input
                                                id="name"
                                                name="name"
                                                type="text"
                                                placeholder="Application name"
                                            />
                                            {errors.name && (
                                                <p className="text-xs text-destructive">
                                                    {errors.name}
                                                </p>
                                            )}
                                        </div>

                                        {/* Driver */}
                                        <div className="flex flex-col gap-2">
                                            <Label>Driver</Label>
                                            <Select name="driver">
                                                <SelectTrigger>
                                                    <SelectValue placeholder="Choose driver" />
                                                </SelectTrigger>
                                                <SelectContent>
                                                    {drivers.map((item) => (
                                                        <SelectItem
                                                            key={item.value}
                                                            value={item.value}
                                                        >
                                                            {item.label}
                                                        </SelectItem>
                                                    ))}
                                                </SelectContent>
                                            </Select>
                                            {errors.driver && (
                                                <p className="text-xs text-destructive">
                                                    {errors.driver}
                                                </p>
                                            )}
                                        </div>
                                    </div>

                                    {/* Row: Consent Redirect + Consent Webhook */}
                                    <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                        {/* Redirect Consent */}
                                        <div className="flex flex-col gap-2">
                                            <Label>Redirect Consent URL</Label>
                                            <Input
                                                id="redirect_consent"
                                                name="redirect_consent"
                                                placeholder="https://example.com/callback/consent"
                                            />
                                            {errors.redirect_consent && (
                                                <p className="text-xs text-destructive">
                                                    {errors.redirect_consent}
                                                </p>
                                            )}
                                        </div>

                                        {/* Webhook consent */}
                                        <div className="flex flex-col gap-2">
                                            <Label>Webhook Consent URL</Label>
                                            <Input
                                                id="webhook_consent"
                                                name="webhook_consent"
                                                placeholder="https://example.com/webhook/consent"
                                            />
                                            {errors.webhook_consent && (
                                                <p className="text-xs text-destructive">
                                                    {errors.webhook_consent}
                                                </p>
                                            )}
                                        </div>
                                    </div>

                                    {/* Row: Collection Redirect + Collection Webhook */}
                                    <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                        {/* Redirect Collection */}
                                        <div className="flex flex-col gap-2">
                                            <Label>
                                                Redirect Collection URL
                                            </Label>
                                            <Input
                                                id="redirect_collection"
                                                name="redirect_collection"
                                                placeholder="https://example.com/collection/callback"
                                            />
                                            {errors.redirect_collection && (
                                                <p className="text-xs text-destructive">
                                                    {errors.redirect_collection}
                                                </p>
                                            )}
                                        </div>

                                        {/* Webhook Collection */}
                                        <div className="flex flex-col gap-2">
                                            <Label>
                                                Webhook Collection URL
                                            </Label>
                                            <Input
                                                id="webhook_collection"
                                                name="webhook_collection"
                                                placeholder="https://example.com/webhook/collection"
                                            />
                                            {errors.webhook_collection && (
                                                <p className="text-xs text-destructive">
                                                    {errors.webhook_collection}
                                                </p>
                                            )}
                                        </div>
                                    </div>

                                    <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                        <div className="flex flex-col gap-2">
                                            <Label>API KEY</Label>
                                            <Input
                                                id="authentication_key"
                                                name="authentication_key"
                                                defaultValue={authenticationKey}
                                                readOnly
                                            />
                                        </div>
                                    </div>
                                </CardContent>

                                <CardFooter>
                                    <Button
                                        disabled={processing}
                                        className="w-full md:w-auto"
                                    >
                                        {processing ? 'Saving...' : 'Create'}
                                    </Button>
                                </CardFooter>
                            </div>
                        )}
                    </Form>
                </Card>
            </div>
        </AppLayout>
    );
}
