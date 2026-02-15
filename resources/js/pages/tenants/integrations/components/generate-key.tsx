import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Integration, Tenant } from '@/types';
import { Form } from '@inertiajs/react';

interface PageProps {
    tenant: Tenant;
    integration: Integration;
    authenticationKey: string;
}

export default function GenerateKey({
    tenant,
    integration,
    authenticationKey,
}: PageProps) {
    return (
        <Card>
            <CardHeader>
                <CardTitle>Regenerate API Key</CardTitle>
            </CardHeader>

            <Form method="post">
                {({ processing }) => (
                    <>
                        <CardContent className="space-y-4">
                            <p className="text-sm text-muted-foreground">
                                This will generate a new application key. Old
                                key will no longer work.
                            </p>
                            <Input
                                name="authentication_key"
                                defaultValue={authenticationKey}
                                readOnly
                            />
                        </CardContent>

                        <CardFooter>
                            <Button disabled={processing} className="">
                                {processing
                                    ? 'Generating...'
                                    : 'Generate New Key'}
                            </Button>
                        </CardFooter>
                    </>
                )}
            </Form>
        </Card>
    );
}
