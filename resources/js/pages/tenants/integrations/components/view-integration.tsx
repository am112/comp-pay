import {
    Sheet,
    SheetBody,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
} from '@/components/ui/sheet';
import { Integration } from '@/types';
import { useDirection } from '@radix-ui/react-direction';

interface PageProps {
    open: boolean;
    onOpenChange: (open: boolean) => void;
    integration: Integration | null;
}

export default function ViewIntegration({
    open,
    onOpenChange,
    integration,
}: PageProps) {
    const direction = useDirection();

    return (
        <Sheet open={open} onOpenChange={onOpenChange}>
            <SheetContent dir={direction} className="min-w-full lg:min-w-3xl">
                <SheetHeader>
                    <SheetTitle>View Application</SheetTitle>
                    <SheetDescription>
                        showing details of applications.
                    </SheetDescription>
                </SheetHeader>
                <SheetBody>
                    <div className="grid gap-6 py-4">
                        <div className="grid grid-cols-2">
                            <Field label="Name" value={integration?.name} />
                            <Field label="Driver" value={integration?.driver} />
                        </div>
                        <Field
                            label="Redirect Consent"
                            value={integration?.redirect_consent}
                        />
                        <Field
                            label="Webhook Consent"
                            value={integration?.webhook_consent}
                        />
                        <Field
                            label="Redirect Collection"
                            value={integration?.redirect_collection}
                        />
                        <Field
                            label="Webhook Collection"
                            value={integration?.webhook_collection}
                        />
                        <Field
                            label="Application Key"
                            value={integration?.authentication_key}
                        />
                    </div>
                </SheetBody>
                <SheetFooter></SheetFooter>
            </SheetContent>
        </Sheet>
    );
}

/**
 * Reusable read-only field
 */
function Field({ label, value }: { label: string; value: any }) {
    return (
        <div className="grid gap-1">
            <p className="text-sm font-medium text-muted-foreground">{label}</p>
            <p className="text-sm">{value ?? '-'}</p>
        </div>
    );
}
