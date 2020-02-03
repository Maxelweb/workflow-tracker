# Workflow Tracker
A simple web-hook that shows a real-time branch workflow and the online status of the contributors in a repository


### Idea

- Webhook based update events
- Info from a collaborator
    - Username
    - Avatar
    - Current pushed branch
    - Current time
- PHP + JS
- JSON file to save new data
- Collaborators are incremental and never deleted 
- Refresh every 10 seconds
- Users grouped by Branches
- User status near username

#### Status

- **Online:** last push >= 20 minutes ago
- **Offline:** last push < 20 minutes ago
