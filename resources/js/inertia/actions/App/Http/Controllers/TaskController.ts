import {
    queryParams,
    type RouteQueryOptions,
    type RouteDefinition,
    type RouteFormDefinition,
    applyUrlDefaults,
} from './../../../../wayfinder';
/**
 * @see \App\Http\Controllers\TaskController::index
 * @see app/Http/Controllers/TaskController.php:14
 * @route '/tasks'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
});

index.definition = {
    methods: ['get', 'head'],
    url: '/tasks',
} satisfies RouteDefinition<['get', 'head']>;

/**
 * @see \App\Http\Controllers\TaskController::index
 * @see app/Http/Controllers/TaskController.php:14
 * @route '/tasks'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options);
};

/**
 * @see \App\Http\Controllers\TaskController::index
 * @see app/Http/Controllers/TaskController.php:14
 * @route '/tasks'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
});
/**
 * @see \App\Http\Controllers\TaskController::index
 * @see app/Http/Controllers/TaskController.php:14
 * @route '/tasks'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
});

/**
 * @see \App\Http\Controllers\TaskController::index
 * @see app/Http/Controllers/TaskController.php:14
 * @route '/tasks'
 */
const indexForm = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\TaskController::index
 * @see app/Http/Controllers/TaskController.php:14
 * @route '/tasks'
 */
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
});
/**
 * @see \App\Http\Controllers\TaskController::index
 * @see app/Http/Controllers/TaskController.php:14
 * @route '/tasks'
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
 * @see \App\Http\Controllers\TaskController::failedRows
 * @see app/Http/Controllers/TaskController.php:30
 * @route '/tasks/failed-rows/{taskId}'
 */
export const failedRows = (
    args:
        | { taskId: string | number }
        | [taskId: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
): RouteDefinition<'get'> => ({
    url: failedRows.url(args, options),
    method: 'get',
});

failedRows.definition = {
    methods: ['get', 'head'],
    url: '/tasks/failed-rows/{taskId}',
} satisfies RouteDefinition<['get', 'head']>;

/**
 * @see \App\Http\Controllers\TaskController::failedRows
 * @see app/Http/Controllers/TaskController.php:30
 * @route '/tasks/failed-rows/{taskId}'
 */
failedRows.url = (
    args:
        | { taskId: string | number }
        | [taskId: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { taskId: args };
    }

    if (Array.isArray(args)) {
        args = {
            taskId: args[0],
        };
    }

    args = applyUrlDefaults(args);

    const parsedArgs = {
        taskId: args.taskId,
    };

    return (
        failedRows.definition.url
            .replace('{taskId}', parsedArgs.taskId.toString())
            .replace(/\/+$/, '') + queryParams(options)
    );
};

/**
 * @see \App\Http\Controllers\TaskController::failedRows
 * @see app/Http/Controllers/TaskController.php:30
 * @route '/tasks/failed-rows/{taskId}'
 */
failedRows.get = (
    args:
        | { taskId: string | number }
        | [taskId: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
): RouteDefinition<'get'> => ({
    url: failedRows.url(args, options),
    method: 'get',
});
/**
 * @see \App\Http\Controllers\TaskController::failedRows
 * @see app/Http/Controllers/TaskController.php:30
 * @route '/tasks/failed-rows/{taskId}'
 */
failedRows.head = (
    args:
        | { taskId: string | number }
        | [taskId: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
): RouteDefinition<'head'> => ({
    url: failedRows.url(args, options),
    method: 'head',
});

/**
 * @see \App\Http\Controllers\TaskController::failedRows
 * @see app/Http/Controllers/TaskController.php:30
 * @route '/tasks/failed-rows/{taskId}'
 */
const failedRowsForm = (
    args:
        | { taskId: string | number }
        | [taskId: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: failedRows.url(args, options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\TaskController::failedRows
 * @see app/Http/Controllers/TaskController.php:30
 * @route '/tasks/failed-rows/{taskId}'
 */
failedRowsForm.get = (
    args:
        | { taskId: string | number }
        | [taskId: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: failedRows.url(args, options),
    method: 'get',
});
/**
 * @see \App\Http\Controllers\TaskController::failedRows
 * @see app/Http/Controllers/TaskController.php:30
 * @route '/tasks/failed-rows/{taskId}'
 */
failedRowsForm.head = (
    args:
        | { taskId: string | number }
        | [taskId: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: failedRows.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        },
    }),
    method: 'get',
});

failedRows.form = failedRowsForm;
const TaskController = { index, failedRows };

export default TaskController;
