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
import { update } from '@/routes/tenants/applications';
import { type BreadcrumbItem, Integration, Tenant } from '@/types';
import { Form, Head } from '@inertiajs/react';
import DeleteIntegration from './components/delete-integration';
import GenerateKey from './components/generate-key';

interface PageProps {
    tenant: Tenant;
    drivers: { label: string; value: string }[];
    integration: Integration;
    authenticationKey: string;
}

export default function IntegrationsEdit({
    tenant,
    drivers,
    integration,
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
            title: 'Edit',
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
                            Edit Application
                        </CardTitle>
                    </CardHeader>

                    <Form
                        {...update.form({
                            tenant: tenant.id,
                            application: integration.id,
                        })}
                    >
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
                                                defaultValue={integration.name}
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
                                            <Select
                                                name="driver"
                                                defaultValue={
                                                    integration.driver
                                                }
                                                disabled
                                            >
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

                                    {/* Row: consent Redirect + consent Webhook */}
                                    <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                        {/* Redirect consent */}
                                        <div className="flex flex-col gap-2">
                                            <Label>Redirect Consent URL</Label>
                                            <Input
                                                id="redirect_consent"
                                                name="redirect_consent"
                                                defaultValue={
                                                    integration.redirect_consent
                                                }
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
                                                defaultValue={
                                                    integration.webhook_consent
                                                }
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
                                                defaultValue={
                                                    integration.redirect_collection
                                                }
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
                                                defaultValue={
                                                    integration.webhook_collection
                                                }
                                                placeholder="https://example.com/webhook/collection"
                                            />
                                            {errors.webhook_collection && (
                                                <p className="text-xs text-destructive">
                                                    {errors.webhook_collection}
                                                </p>
                                            )}
                                        </div>
                                    </div>
                                </CardContent>

                                <CardFooter>
                                    <Button
                                        disabled={processing}
                                        className="w-full md:w-auto"
                                    >
                                        {processing ? 'Saving...' : 'Update'}
                                    </Button>
                                </CardFooter>
                            </div>
                        )}
                    </Form>
                </Card>

                <div className="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                    {/* Delete Application */}
                    <DeleteIntegration
                        tenant={tenant}
                        integration={integration}
                    />

                    {/* Generate API Key */}
                    <GenerateKey
                        tenant={tenant}
                        integration={integration}
                        authenticationKey={authenticationKey}
                    />
                </div>
            </div>
        </AppLayout>
    );
}
