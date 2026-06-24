import CreateTaskDropdown from '@/Components/CreateTaskDropdown';
import Button from '@/Components/Shared/Button';
import AppLayout from '@/Layouts/AppLayout';
import ProfileLayout from '@/Layouts/ProfileLayout';
import UserLayout from '@/Layouts/UserLayout';
import { PageProps } from '@/types';
import User from '@/types/models/user';
import { Checkbox, Link } from '@heroui/react';
import { Head } from '@inertiajs/react';
import { useLaravelReactI18n } from 'laravel-react-i18n';
import React from 'react';
import MaterialSymbolsAccountCircleFull from '~icons/material-symbols/account-circle-full';
import MaterialSymbolsAd from '~icons/material-symbols/ad';
import MaterialSymbolsBuild from '~icons/material-symbols/build';
import MaterialSymbolsCreditCard from '~icons/material-symbols/credit-card';
import MaterialSymbolsDeleteOutline from '~icons/material-symbols/delete-outline';
import MaterialSymbolsDistanceOutline from '~icons/material-symbols/distance-outline';
import MaterialSymbolsMailOutline from '~icons/material-symbols/mail-outline';
import MaterialSymbolsNotificationsOutline from '~icons/material-symbols/notifications-outline';

export default function GeneralInfo({
    user,
    auth,
    cities,
}: PageProps<{
    user: User;
    cities: string[];
}>) {
    const { t } = useLaravelReactI18n();

    const user1 = {
        id: 1,
        avatar: 'https://cdn.mos.cms.futurecdn.net/aLt5gVBGkBctmjY6Ed7v7g.png',
        name: 'Тiм К.',
        phone: '+380 98 677 78 88',
        email: 'itstep.kyiv@gmail.com',
        city: 'Kyiv',
        rating: '4.5',
        birth_date: '01.09.201',
        gender: 'Male',
        certificates: [
            {
                id: 'cert-1',
                title: 'Frontend Development',
                image: 'https://mastera-remonta.com/wp-content/uploads/2019/08/remont-kvartir.jpg',
            },
            {
                id: 'cert-2',
                title: 'UI/UX Design',
                image: 'https://media.licdn.com/dms/image/v2/D5622AQE7byBwiq-nVg/feedshare-shrink_800/feedshare-shrink_800/0/1719756097829?e=2147483647&v=beta&t=ArIwywMFDccQXC0c1TeAhmVdZlS2pHJbRoZ0QUegLmU',
            },
            {
                id: 'cert-3',
                title: 'React Advanced',
                image: 'https://media.licdn.com/dms/image/v2/D5622AQEuVfx6HRVG5w/feedshare-shrink_800/feedshare-shrink_800/0/1721729211619?e=2147483647&v=beta&t=eVyt17cfmmzH75dk2r7IuKleBcs-X1uVYieY0dHAyFA',
            },
            {
                id: 'cert-4',
                title: 'UI/UX Design',
                image: 'https://media.licdn.com/dms/image/v2/D5622AQE7byBwiq-nVg/feedshare-shrink_800/feedshare-shrink_800/0/1719756097829?e=2147483647&v=beta&t=ArIwywMFDccQXC0c1TeAhmVdZlS2pHJbRoZ0QUegLmU',
            },
            {
                id: 'cert-5',
                title: 'UI/UX Design',
                image: 'https://digitallycode.com/wp-content/uploads/2024/09/dg_certificate.webp',
            },
        ],
        about_me:
            'Lorem ipsum dolor sit amet, ipsum dconsectetur adipiscing elit. Aenean in fermentum ante. Sed rutrum ac odio eu posuere. Quisque erat urna, semper ac nunc non, iaculis consectetur ligula. Nam tincidunt aliquam felis quis accumsan. ',
        education: [
            'Київський професійно-педагогічний коледж імені Антона Макаренка',
            'It-Step Розробка програмного забезпечення',
        ],
    };

    return (
        <>
            <Head title={`${t('user-layout.general-info-tab')} - ${user.name}`} />

            <div className="space-y-4">
                <div className="flex items-start gap-[0.75rem] p-[0.75rem]">
                    <MaterialSymbolsMailOutline className="h-[1.5rem] w-[1.5rem] min-w-[1.5rem]" />

                    <div className="flex gap-[0.75rem] text-[1.25rem] leading-[1.375rem]">
                        <div className="">
                            {t('profile.general-info.contact_email')}
                            {user.email}
                        </div>
                    </div>
                </div>

                <div className="flex items-start gap-[0.75rem] p-[0.75rem]">
                    <MaterialSymbolsAccountCircleFull className="h-[1.5rem] w-[1.5rem] min-w-[1.5rem]" />

                    <div className="flex flex-col gap-[0.5rem] text-[1.25rem] leading-[1.375rem]">
                        <div className="">
                            {t('profile.general-info.city')}
                            {user.city}
                        </div>

                        <div className="">
                            {t('profile.general-info.birth_date')}
                            {user1.birth_date ? (
                                user1.birth_date
                            ) : (
                                <Link className="text-primary">
                                    {' '}
                                    {t('profile.general-info.add')}
                                </Link>
                            )}
                        </div>

                        <div className="">
                            {t('profile.general-info.gender')}
                            {user1.gender ? (
                                user1.gender
                            ) : (
                                <Link className="text-primary">
                                    {' '}
                                    {t('profile.general-info.add')}
                                </Link>
                            )}
                        </div>

                        <div className="">
                            {t('profile.general-info.about_me')}
                            {user1.about_me ? (
                                user1.about_me
                            ) : (
                                <span className="text-primary">
                                    {' '}
                                    {t('profile.general-info.add')}
                                </span>
                            )}
                        </div>
                    </div>
                </div>

                <div className="flex items-start gap-[0.75rem] p-[0.75rem]">
                    <MaterialSymbolsBuild className="h-[1.5rem] w-[1.5rem] min-w-[1.5rem]" />

                    <div className="flex flex-col gap-[0.75rem] text-[1.25rem] leading-[1.375rem]">
                        {t('profile.general-info.order_categories')}
                        <CreateTaskDropdown employee={user.id}>
                            <Link
                                as={'button'}
                                className="text-primary text-[1.25rem] leading-[1.375rem] hover:cursor-pointer"
                            >
                                {t('profile.general-info.create_ad')}
                            </Link>
                        </CreateTaskDropdown>
                    </div>
                </div>

                <div className="flex items-start gap-[0.75rem] p-[0.75rem]">
                    <MaterialSymbolsAd className="h-[1.5rem] w-[1.5rem] min-w-[1.5rem]" />

                    <div className="flex flex-col gap-[0.75rem] text-[1.25rem] leading-[1.375rem]">
                        {t('profile.general-info.my_ads')}
                        <CreateTaskDropdown employee={user.id}>
                            <Link
                                as={'button'}
                                className="text-primary text-[1.25rem] leading-[1.375rem] hover:cursor-pointer"
                            >
                                {t('profile.general-info.create_ad')}
                            </Link>
                        </CreateTaskDropdown>
                    </div>
                </div>

                <div className="flex items-start gap-[0.75rem] p-[0.75rem]">
                    <MaterialSymbolsDistanceOutline className="h-[1.5rem] w-[1.5rem] min-w-[1.5rem]" />

                    <div className="flex flex-col gap-[0.75rem] text-[1.25rem] leading-[1.375rem]">
                        {t('profile.general-info.order_cities')}
                        <div className="flex flex-wrap gap-3">
                            {cities.map((city) => (
                                <Button
                                    key={city}
                                    className="bg-0 w-fit rounded-[0.75rem] border-1"
                                >
                                    {city}
                                </Button>
                            ))}
                        </div>
                    </div>
                </div>

                <div className="flex items-start gap-[0.75rem] p-[0.75rem]">
                    <MaterialSymbolsCreditCard className="h-[1.5rem] w-[1.5rem] min-w-[1.5rem]" />

                    <div className="flex flex-col gap-[0.75rem] text-[1.25rem] leading-[1.375rem]">
                        {t('profile.general-info.payment_info')}

                        <CreateTaskDropdown employee={user.id}>
                            <Link
                                as={'button'}
                                className="text-primary text-[1.25rem] leading-[1.375rem] hover:cursor-pointer"
                            >
                                {t('profile.general-info.create_ad')}
                            </Link>
                        </CreateTaskDropdown>
                    </div>
                </div>

                {user.id === auth.user?.id && (
                    <div className="p-4">
                        <div className="flex items-start gap-[0.75rem]">
                            <MaterialSymbolsNotificationsOutline className="h-[1.5rem] w-[1.5rem] min-w-[1.5rem]" />

                            <div className="flex flex-col gap-[0.75rem]">
                                <div className="text-[1.25rem] leading-[1.375rem]">
                                    {t('profile.general-info.notification_settings')}
                                </div>
                                <Checkbox
                                    value="1"
                                    className="w-full gap-[0.625rem] pt-[0.75rem] text-[1.25rem] leading-[1.375rem]"
                                >
                                    {t('profile.general-info.email_status_updates')}
                                </Checkbox>

                                <Checkbox
                                    value=""
                                    className="w-full gap-[0.625rem] text-[1.25rem] leading-[1.6875rem]"
                                >
                                    {t('profile.general-info.email_new_orders')}
                                </Checkbox>
                            </div>
                        </div>
                    </div>
                )}

                {user.id === auth.user?.id && (
                    <div className="flex items-start gap-[0.75rem] p-[0.75rem]">
                        <MaterialSymbolsDeleteOutline className="h-[1.5rem] w-[1.5rem] min-w-[1.5rem]" />

                        <div className="flex flex-col gap-[0.75rem] text-[1.25rem] leading-[1.375rem]">
                            {t('profile.general-info.delete_profile')}
                            <div className="text-primary">{t('profile.general-info.delete')}</div>
                        </div>
                    </div>
                )}
            </div>
        </>
    );
}

GeneralInfo.layout = (page: React.ReactNode) => (
    <AppLayout>
        <UserLayout>
            <ProfileLayout>{page}</ProfileLayout>
        </UserLayout>
    </AppLayout>
);
