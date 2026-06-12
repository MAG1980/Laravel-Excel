import ProjectController from './ProjectController';
import Settings from './Settings';
import TaskController from './TaskController';
const Controllers = {
    ProjectController: Object.assign(ProjectController, ProjectController),
    TaskController: Object.assign(TaskController, TaskController),
    Settings: Object.assign(Settings, Settings),
};

export default Controllers;
