import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { destroy } from '@/routes/tenants/applications';
import { Integration, Tenant } from '@/types';
import { Form } from '@inertiajs/react';

interface PageProps {
    tenant: Tenant;
    integration: Integration;
}

export default function DeleteIntegration({ tenant, integration }: PageProps) {
    return (
        <Card>
            <CardHeader>
                <CardTitle className="text-red-600">
                    Delete Application
                </CardTitle>
            </CardHeader>

            <Form
                {...destroy.form({
                    tenant: tenant.id,
                    application: integration.id,
                })}
                options={{
                    preserveState: true,
                    preserveScroll: true,
                }}
            >
                {({ processing, errors }) => (
                    <>
                        <CardContent className="space-y-4">
                            <p className="text-sm text-muted-foreground">
                                Type <strong>{integration.name}</strong> to
                                confirm deletion.
                            </p>

                            <Input
                                name="confirm_name"
                                placeholder={integration.name}
                            />

                            {errors.confirm_name && (
                                <p className="text-xs text-destructive">
                                    {errors.confirm_name}
                                </p>
                            )}
                        </CardContent>

                        <CardFooter>
                            <Button
                                variant="destructive"
                                type="submit"
                                disabled={processing}
                            >
                                {processing ? 'Deleting...' : 'Delete'}
                            </Button>
                        </CardFooter>
                    </>
                )}
            </Form>
        </Card>
    );
}
