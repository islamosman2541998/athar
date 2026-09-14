<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromQuery, WithMapping, WithHeadings
{
    protected Request $request;
    protected string $locale;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->locale  = app()->getLocale();
    }

    public function query()
    {
        $req = $this->request;

        $query = Product::query()
            ->with([
                'transNow',
                'translations',
                'occasions.translations',
                'productCategoriesProducts.translations',
                'pockets.translations',
                'filters.translations',
                'rates',
                'createdBy',
                'updatedBy',
            ])
            ->orderBy('id', 'DESC');

        // Status filter
        if ($req->filled('status')) {
            if ($req->status == 1) {
                $query->where('status', 1);
            } else {
                $query->where('status', '!=', 1);
            }
        }

        // Title, Description, Care Tips (translations)
        if ($req->filled('title')) {
            $query->whereTranslationLike('title', "%{$req->title}%");
        }
        if ($req->filled('description')) {
            $query->whereTranslationLike('description', "%{$req->description}%");
        }
        if ($req->filled('care_tips')) {
            $query->whereTranslationLike('care_tips', "%{$req->care_tips}%");
        }

        // Code filter
        if ($req->filled('code')) {
            $query->where('code', 'like', "%{$req->code}%");
        }

        // Average rating filter
        if ($req->filled('rate')) {
            $query->whereHas('rates', function ($q) use ($req) {
                $q->selectRaw('AVG(rating_value) as avg_rating_value')
                  ->groupBy('product_id')
                  ->havingRaw('AVG(rating_value) like ?', ["%{$req->rate}%"]);
            });
        }

        // Price range filter
        if ($req->filled('from_price')) {
            $query->where('price', '>=', $req->from_price);
        }
        if ($req->filled('to_price')) {
            $query->where('price', '<=', $req->to_price);
        }

        // Date range filter
        if ($req->filled('from_date') || $req->filled('to_date')) {
            $from = $req->filled('from_date')
                ? Carbon::parse($req->from_date)
                : Carbon::create(2000, 1, 1);
            $to = $req->filled('to_date')
                ? Carbon::parse($req->to_date)->endOfDay()
                : now();
            $query->whereBetween('created_at', [$from, $to]);
        }

        // Occasions filter
        if ($req->filled('occasions')) {
            $query->whereHas('occasions', function ($q) use ($req) {
                $q->whereTranslationLike('title', $req->occasions);
            });
        }

        // Categories filter
        if ($req->filled('cat_id')) {
            $query->whereHas('productCategoriesProducts', function ($q) use ($req) {
                $q->whereTranslationLike('title', $req->cat_id);
            });
        }

        // Filters filter
        if ($req->filled('filters')) {
            $query->whereHas('filters', function ($q) use ($req) {
                $q->whereTranslationLike('title', $req->filters);
            });
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Code',
            'Price',
            'Sale',
            'Price After Sale',
            // 'Most Selling',
            // 'Best Offer',
            // 'Feature',
            // 'Status',
            // 'In Stock',
            // 'Show In Cart',
            'Sort',
            'Created By',
            'Updated By',
            'Created At',
            'Updated At',

            // Translation fields
            'Title',
            'Description',
            // 'Slug',
            // 'Meta Title',
            // 'Meta Description',
            // 'Meta Key',

            // Relationships
            // 'Occasions',
            // 'Categories',
            // 'Pockets',
            // 'Filters',
            // 'Average Rating',
        ];
    }

    public function map($product): array
    {
        // Basic attributes
        $data = [
            $product->id,
            $product->code,
            $product->price,
            $product->sale,
            $product->price_after_sale,
            // $product->most_selling,
            // $product->best_offer,
            // $product->feature,
            // $product->status,
            // $product->in_stock,
            // $product->show_in_cart,
            $product->sort,
            optional($product->createdBy)->name,
            optional($product->updatedBy)->name,
            $product->created_at->toDateTimeString(),
            $product->updated_at->toDateTimeString(),
        ];

        // Translations (current locale)
        $trans = $product->translate($this->locale);
        $data[] = $trans->title ?? '';
        $data[] = $trans->description ?? '';
        // $data[] = $trans->slug ?? '';
        // $data[] = $trans->meta_title ?? '';
        // $data[] = $trans->meta_description ?? '';
        // $data[] = $trans->meta_key ?? '';

        // Relationships: join titles by comma
        // $data[] = $product->occasions->pluck('transByLocale')->map(fn($t) => $t->title ?? '')->implode(', ');
        // $data[] = $product->productCategoriesProducts->pluck('transByLocale')->map(fn($t) => $t->title ?? '')->implode(', ');
        // $data[] = $product->pockets->pluck('transByLocale')->map(fn($t) => $t->name ?? '')->implode(', ');
        // $data[] = $product->filters->pluck('transByLocale')->map(fn($t) => $t->name ?? '')->implode(', ');

        // // Average rating
        // $avgRating = $product->rates->avg('rating_value') ?? 0;
        // $data[] = number_format($avgRating, 2);

        return $data;
    }
}
