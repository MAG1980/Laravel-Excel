import type { Type } from '@inertia/types/type';

export type Project = {
    id: number;
    type: Type;
    title: string;
    createdAtDate: Date;
    workerCount: number;
    serviceCount: number;
    hasInvestors: string;
    hasOutsource: string;
    isOnTime: string;
    isNetwork: string;
    deadline: Date;
    contractedAt: Date;
};
