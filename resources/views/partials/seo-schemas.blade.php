{{-- Organization Schema --}}
@if(isset($showOrganization) && $showOrganization)
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Thuetaikhoan.net",
    "url": "{{ url('/') }}",
    "logo": "{{ asset('images/logo.png') }}",
    "description": "Hệ thống cho thuê tài khoản UnlockTool, Vietmap Live, Griffin, TSM Tool tự động 24/7",
    "contactPoint": {
        "@type": "ContactPoint",
        "contactType": "customer service",
        "availableLanguage": "Vietnamese"
    },
    "sameAs": [
        "https://www.facebook.com/thuetaikhoan.net"
    ]
}
</script>
@endif

{{-- WebSite Schema with SearchAction --}}
@if(isset($showWebsite) && $showWebsite)
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "Thuetaikhoan.net",
    "url": "{{ url('/') }}",
    "potentialAction": {
        "@type": "SearchAction",
        "target": {
            "@type": "EntryPoint",
            "urlTemplate": "{{ url('/tim-kiem') }}?q={search_term_string}"
        },
        "query-input": "required name=search_term_string"
    }
}
</script>
@endif

{{-- BreadcrumbList Schema --}}
@if(isset($breadcrumbs) && count($breadcrumbs) > 0)
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        @foreach($breadcrumbs as $index => $crumb)
        {
            "@type": "ListItem",
            "position": {{ $index + 1 }},
            "name": "{{ $crumb['name'] }}",
            "item": "{{ $crumb['url'] }}"
        }@if(!$loop->last),@endif
        @endforeach
    ]
}
</script>
@endif

{{-- Product/Service Schema --}}
@if(isset($productSchema))
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "{{ $productSchema['name'] }}",
    "description": "{{ $productSchema['description'] }}",
    "image": "{{ $productSchema['image'] }}",
    "brand": {
        "@type": "Brand",
        "name": "Thuetaikhoan.net"
    },
    "offers": {
        "@type": "AggregateOffer",
        "priceCurrency": "VND",
        "lowPrice": "{{ $productSchema['lowPrice'] }}",
        "highPrice": "{{ $productSchema['highPrice'] }}",
        "offerCount": "{{ $productSchema['offerCount'] }}",
        "availability": "{{ $productSchema['available'] ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}"
    }
}
</script>
@endif

{{-- FAQPage Schema --}}
@if(isset($faqSchema) && count($faqSchema) > 0)
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        @foreach($faqSchema as $faq)
        {
            "@type": "Question",
            "name": "{{ $faq['q'] }}",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "{{ $faq['a'] }}"
            }
        }@if(!$loop->last),@endif
        @endforeach
    ]
}
</script>
@endif
