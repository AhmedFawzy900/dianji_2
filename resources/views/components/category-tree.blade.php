<div class="col-md-4">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Categories</h2>
            <input type="text" id="categorySearch" placeholder="Search Category..." class="form-control mb-3">
            <ul id="categoryTree">
                @foreach ($categories as $category)
                    <li>
                        <span>{{ $category->name }}</span>
                        @if ($category->subcategories !== null)
                            <ul>
                                @foreach ($category->subcategories as $subcategory)
                                    <li>
                                        <span>{{ $subcategory->name }}</span>
                                        @if ($subcategory->subsubcategories !== null)
                                            <ul>
                                                @foreach ($subcategory->subsubcategories as $relatedSubcategory)
                                                    <li><span>{{ $relatedSubcategory->name }}</span></li>
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

ul {
    list-style-type: none;
    padding-left: 20px;
}

ul li {
    margin-bottom: 5px;
    position: relative;
}

ul li:before {
    content: '';
    position: absolute;
    left: -15px;
    top: 10px;
    height: 15px;
    width: 15px;
    border-left: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
}

ul li:last-child:before {
    border-left: 1px solid transparent;
}

ul ul li:before {
    border-left: 1px solid #ccc;
    border-bottom: none;
}
.hidden {
    display: none;
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