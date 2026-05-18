export function isOwner(user) {
    return user.roles.includes('owner');
}
