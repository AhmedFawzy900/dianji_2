<div class="ratting">
   {{#if @partial-block}}
   {{> @partial-block }}
   {{else}}
   {{#for 6}}
   {{#compare ../rating '>=' this}}
   {{> components/widgets/rating-star fill="true"}}
   {{else}}
   {{> components/widgets/rating-star}}
   {{/compare}}
   {{/for}}
   {{/if}}
</div>