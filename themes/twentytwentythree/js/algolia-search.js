const searchClient = algoliasearch("yourAppId", "yourSearchAPIKey");

const search = instantsearch({
  indexName: "post",
  searchClient,
  searchFunction(helper) {
    // Ensure we only trigger a search when there's a query
    if (helper.state.query) {
      helper.search();
    }
  },
});

search.addWidgets([
  instantsearch.widgets.searchBox({
    container: "#searchbox",
  }),

//   instantsearch.widgets.refinementList({
//     container: "#tags-list",
//     attribute: "tags",
//     limit: 5,
//     showMore: true,
//   }),

  instantsearch.widgets.hits({
    container: "#hits",
    templates: {
      item: `
      <article>
        <a href="{{ guid }}">
          <strong>
            {{#helpers.highlight}}
              { "attribute": "post_title", "highlightedTagName": "mark" }
            {{/helpers.highlight}}
          </strong>
        </a>
        {{#content}}
          <p>{{#helpers.snippet}}{ "attribute": "post_content", "highlightedTagName": "mark" }{{/helpers.snippet}}</p>
        {{/content}}
      </article>
    `,
    },
  }),
]);

search.start();
