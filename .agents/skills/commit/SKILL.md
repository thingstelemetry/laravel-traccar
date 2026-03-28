---
name: commit
description: Use for managing commits, branching, and pull requests in the Laravel WAHA project to ensure a clean and logical git history.
---

# Commit Skill

This skill provides instructions for managing commits and pull requests in the Laravel WAHA project, ensuring a clean and logical git history.

## General Rules

- **Branching:** Never commit directly to the `main` branch. Always create a new branch for your changes.
- **Branch Naming:** Name your branch based on the changes (e.g., `update-readme`, `fix-session-auth`, `add-status-endpoint`).
- **Logical Grouping:** Before committing, group local changes into logical changelists. Avoid lumping unrelated changes into a single commit.
- **Commit Messages:**
  - Do NOT use prefixes like `feat:`, `fix:`, `chore:`, etc.
  - Write clear, descriptive commit messages that explain *what* and *why*.
- **Pull Requests:**
  - Do NOT use prefixes like `feat:`, `fix:`, etc. in PR titles.
  - Only push or open a PR when explicitly requested. If not requested, only commit your changes locally.
- **Tooling:** Always use the local `gh` CLI for interacting with GitHub (creating PRs, checking status, etc.).

## Workflow

### 1. Preparation
Check the current status and branch:
```bash
git status
git branch
```

### 2. Branching
Create a new branch if you are on `main`:
```bash
git checkout -b <branch-name>
```

### 3. Staging and Committing
Stage files for a logical change and commit them:
```bash
git add <file1> <file2>
git commit -m "Description of this logical change"
```
Repeat for other logical groups of changes.

### 4. Pushing and PR (Only when requested)
Push the branch and create a PR using the `gh` CLI:
```bash
git push origin <branch-name>
gh pr create --title "Descriptive PR Title" --body "Detailed description of changes"
```
