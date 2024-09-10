<div class="">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title" style="text-align: right;">الفئات</h2>
            <input type="text" id="categorySearch" placeholder="ابحث عن فئة..." class="form-control mb-3" style="direction: rtl; text-align: right;">
            <ul id="categoryTree" style="direction: rtl;">
                @foreach ($categories as $category)
                    <li>
                        <span>{{ $category->name }}</span>
                        @if ($category->subcategories !== null)
                            <ul>
                                @foreach ($category->subcategories as $subcategory)
                                    <li>
                                        <span>{{ $subcategory->name }}</span>
                                        @if ($subcategory->subcategorieslevel3 !== null)
                                            <ul>
                                                @foreach ($subcategory->subcategorieslevel3 as $subcategorieslevel3)
                                                    <li>
                                                        <span>{{ $subcategorieslevel3->name }}</span>
                                                        @if ($subcategorieslevel3->subcategorieslevel4 !== null)
                                                            <ul>
                                                                @foreach ($subcategorieslevel3->subcategorieslevel4 as $subcategorieslevel4)
                                                                    <li>
                                                                        <span>{{ $subcategorieslevel4->name }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>      
</div>

<style>
ul{
list-style-type: none !important;
}
ul#categoryTree {
    list-style-type: none;
    padding-right: 20px;
    padding-left: 0;
    direction: rtl;
}

#categoryTree li {
    margin-bottom: 5px;
    position: relative;
}

ul#categoryTree li:before {
    content: '';
    position: absolute;
    right: -15px;
    top: 10px;
    height: 15px;
    width: 15px;
    border-right: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
}

ul#categoryTree li:last-child:before {
    border-right: 1px solid transparent;
}

ul#categoryTree ul li:before {
    border-right: 1px solid #ccc;
    border-bottom: none;
}

.hidden {
    display: none;
}

.card-title {
    font-size: 24px;
    font-weight: bold;
}

input#categorySearch {
    text-align: right;
}

#categoryTree span {
    cursor: pointer;
}
</style>

<script>
document.querySelectorAll('li').forEach(function(item) {
    item.addEventListener('click', function(event) {
        event.stopPropagation();
        let children = this.querySelector('ul');
        if (children) {
            children.classList.toggle('hidden');
        }
    });
});

// Filter categories based on search input
document.getElementById('categorySearch').addEventListener('keyup', function() {
    let filter = this.value.toUpperCase();
    let categories = document.querySelectorAll('#categoryTree li');

    categories.forEach(function(category) {
        let text = category.querySelector('span').textContent || category.querySelector('span').innerText;
        if (text.toUpperCase().indexOf(filter) > -1) {
            category.style.display = "";
        } else {
            category.style.display = "none";
        }
    });
});
</script>
