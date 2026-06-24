import SafeHtml from '@/Components/SafeHtml';
import Button from '@/Components/Shared/Button';
import Category from '@/types/models/category';
import { Image, Link } from '@heroui/react';
import isSvg from 'is-svg';
import { useLaravelReactI18n } from 'laravel-react-i18n';

const Categories = ({ categories }: { categories: Category[] }) => {
    const { t } = useLaravelReactI18n();
    console.log(categories.map(c => ({ id: c.id, icon: c.icon })));

    return (
        <div className="flex flex-col items-center gap-6 p-6">
            <h2 className="text-2xl font-semibold">{t('categories.popular_categories')}</h2>
            <div className="grid w-full grid-cols-2 gap-4 sm:grid-cols-[repeat(auto-fill,minmax(12rem,1fr))]">
                {categories.map((category) => (
                    <Button
                        key={category.id}
                        color="primary"
                        className="flex aspect-square size-full transform flex-col items-center justify-end gap-2 p-4 text-center text-lg font-bold text-white shadow-lg duration-300 hover:scale-105 active:scale-95"
                    >
                        {category.icon &&
                            (isSvg(category.icon) ? (
                                <SafeHtml<'svg'>
                                    className="m-auto aspect-square h-3/5 min-w-max"
                                    html={category.icon}
                                />
                            ) : (
                                <Image
                                    src={category.icon}
                                    alt={category.name.current}
                                    width=""
                                    height=""
                                    className="aspect-square h-full w-fit object-cover"
                                    classNames={{
                                        wrapper: 'h-3/5 m-auto w-min aspect-square',
                                    }}
                                />
                            ))}
                        <div className="w-full">
                            <span className="inline-block min-h-fit w-full overflow-hidden text-ellipsis">
                                {category.name.current}
                            </span>
                        </div>
                    </Button>
                ))}
            </div>
            <Link href="#" className="text-primary text-lg underline">
                {t('categories.all_categories')}
            </Link>
        </div>
    );
};

export default Categories;
