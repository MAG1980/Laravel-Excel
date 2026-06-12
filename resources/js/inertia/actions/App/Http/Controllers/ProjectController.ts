import {
    queryParams,
    type RouteQueryOptions,
    type RouteDefinition,
    type RouteFormDefinition,
} from './../../../../wayfinder';
/**
 * @see \App\Http\Controllers\ProjectController::index
 * @see app/Http/Controllers/ProjectController.php:38
 * @route '/projects'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
});

index.definition = {
    methods: ['get', 'head'],
    url: '/projects',
} satisfies RouteDefinition<['get', 'head']>;

/**
 * @see \App\Http\Controllers\ProjectController::index
 * @see app/Http/Controllers/ProjectController.php:38
 * @route '/projects'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options);
};

/**
 * @see \App\Http\Controllers\ProjectController::index
 * @see app/Http/Controllers/ProjectController.php:38
 * @route '/projects'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
});
/**
 * @see \App\Http\Controllers\ProjectController::index
 * @see app/Http/Controllers/ProjectController.php:38
 * @route '/projects'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
});

/**
 * @see \App\Http\Controllers\ProjectController::index
 * @see app/Http/Controllers/ProjectController.php:38
 * @route '/projects'
 */
const indexForm = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\ProjectController::index
 * @see app/Http/Controllers/ProjectController.php:38
 * @route '/projects'
 */
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
});
/**
 * @see \App\Http\Controllers\ProjectController::index
 * @see app/Http/Controllers/ProjectController.php:38
 * @route '/projects'
 */
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        },
    }),
    method: 'get',
});

index.form = indexForm;
/**
 * @see \App\Http\Controllers\ProjectController::importShow
 * @see app/Http/Controllers/ProjectController.php:46
 * @route '/projects/import'
 */
export const importShow = (
    options?: RouteQueryOptions,
): RouteDefinition<'get'> => ({
    url: importShow.url(options),
    method: 'get',
});

importShow.definition = {
    methods: ['get', 'head'],
    url: '/projects/import',
} satisfies RouteDefinition<['get', 'head']>;

/**
 * @see \App\Http\Controllers\ProjectController::importShow
 * @see app/Http/Controllers/ProjectController.php:46
 * @route '/projects/import'
 */
importShow.url = (options?: RouteQueryOptions) => {
    return importShow.definition.url + queryParams(options);
};

/**
 * @see \App\Http\Controllers\ProjectController::importShow
 * @see app/Http/Controllers/ProjectController.php:46
 * @route '/projects/import'
 */
importShow.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: importShow.url(options),
    method: 'get',
});
/**
 * @see \App\Http\Controllers\ProjectController::importShow
 * @see app/Http/Controllers/ProjectController.php:46
 * @route '/projects/import'
 */
importShow.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: importShow.url(options),
    method: 'head',
});

/**
 * @see \App\Http\Controllers\ProjectController::importShow
 * @see app/Http/Controllers/ProjectController.php:46
 * @route '/projects/import'
 */
const importShowForm = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: importShow.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\ProjectController::importShow
 * @see app/Http/Controllers/ProjectController.php:46
 * @route '/projects/import'
 */
importShowForm.get = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: importShow.url(options),
    method: 'get',
});
/**
 * @see \App\Http\Controllers\ProjectController::importShow
 * @see app/Http/Controllers/ProjectController.php:46
 * @route '/projects/import'
 */
importShowForm.head = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: importShow.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        },
    }),
    method: 'get',
});

importShow.form = importShowForm;
/**
 * @see \App\Http\Controllers\ProjectController::importStore
 * @see app/Http/Controllers/ProjectController.php:19
 * @route '/projects/import'
 */
export const importStore = (
    options?: RouteQueryOptions,
): RouteDefinition<'post'> => ({
    url: importStore.url(options),
    method: 'post',
});

importStore.definition = {
    methods: ['post'],
    url: '/projects/import',
} satisfies RouteDefinition<['post']>;

/**
 * @see \App\Http\Controllers\ProjectController::importStore
 * @see app/Http/Controllers/ProjectController.php:19
 * @route '/projects/import'
 */
importStore.url = (options?: RouteQueryOptions) => {
    return importStore.definition.url + queryParams(options);
};

/**
 * @see \App\Http\Controllers\ProjectController::importStore
 * @see app/Http/Controllers/ProjectController.php:19
 * @route '/projects/import'
 */
importStore.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: importStore.url(options),
    method: 'post',
});

/**
 * @see \App\Http\Controllers\ProjectController::importStore
 * @see app/Http/Controllers/ProjectController.php:19
 * @route '/projects/import'
 */
const importStoreForm = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'post'> => ({
    action: importStore.url(options),
    method: 'post',
});

/**
 * @see \App\Http\Controllers\ProjectController::importStore
 * @see app/Http/Controllers/ProjectController.php:19
 * @route '/projects/import'
 */
importStoreForm.post = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'post'> => ({
    action: importStore.url(options),
    method: 'post',
});

importStore.form = importStoreForm;
const ProjectController = { index, importShow, importStore };

export default ProjectController;
