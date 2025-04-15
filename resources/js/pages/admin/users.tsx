import AppLayout from "@/layouts/app-layout";
import { BreadcrumbItem } from "@/types";
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [{
  title: 'Users',
  href: '/admin/users',
}]

export default function Users() {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Users"/>
      
    </AppLayout>
  )
}