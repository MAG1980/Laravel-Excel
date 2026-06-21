import type { User } from '@spa/interfaces';

export interface AuthState {
    user: User | null;
    isLoggedIn: boolean;
    isLoading: boolean;
}
