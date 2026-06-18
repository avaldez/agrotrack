---
name: Skill Creator
description: A skill designed to help the agent create, structure, and generate other Antigravity skills based on official best practices.
---

# Skill Creator

This skill is designed to guide the creation of new Antigravity skills. Antigravity skills are modular logic blocks, instructions, scripts, and resources that extend an agent's capabilities for specialized tasks.

## Skill Structure

Every skill is essentially a folder containing specific files. The most critical component is the `SKILL.md` file.

A standard skill folder might look like this:
```
<skill-name>/
├── SKILL.md          # (Required) Main instructions with YAML frontmatter
├── scripts/          # (Optional) Helper scripts and utilities
├── examples/         # (Optional) Reference implementations
├── resources/        # (Optional) Additional files, templates, or assets
└── references/       # (Optional) Additional documentation for the agent
```

## Creating a New Skill

When instructed to create a new skill, follow these exact steps:

### 1. Define the Scope and Name
- Identify the exact purpose of the skill.
- Choose a concise, descriptive, and lower-kebab-case name for the folder (e.g., `api-integration-helper`).
- Create the folder in the designated skills directory (usually `agents/skills/`).

### 2. Create the `SKILL.md` File
Create the `SKILL.md` file inside the new folder. This file **must** contain YAML frontmatter at the very top.

**Frontmatter format:**
```yaml
---
name: [Human Readable Skill Name]
description: [A short, clear description of what the skill does, helping the agent know when to invoke it.]
---
```

### 3. Write the Markdown Instructions
Below the frontmatter, write the detailed markdown instructions. Structure the document clearly:

- **Introduction:** Briefly explain the skill.
- **When to Use:** Provide scenarios for when the agent should apply this skill.
- **Workflow / Steps:** Provide a step-by-step numbered list of instructions the agent must follow. Make them highly specific and actionable.
- **Rules & Constraints:** Detail what the agent should **never** do or strict rules it must follow.
- **Examples (Optional):** Show input/output examples or command usage.

### Example `SKILL.md` Template

```markdown
---
name: Database Migrator
description: Automates the process of creating and running database migrations.
---

# Database Migrator

Use this skill whenever the user requests changes to the database schema.

## Workflow

1. **Analyze Schema Changes:** Review the required changes.
2. **Generate Migration:** Run the framework's migration command.
3. **Verify:** Review the generated migration file for correctness.

## Rules
- NEVER run destructive migrations (`drop table`) without explicit user approval.
- Always include rollback instructions.
```

### 4. Create Supporting Assets (If Needed)
If the skill requires executing custom bash scripts or reading templates, create the appropriate subdirectories (`scripts/`, `resources/`) and populate them. Ensure the `SKILL.md` references these files correctly (using absolute or relative paths as appropriate).

## Best Practices
- **Be Explicit:** Agents follow instructions literally. Do not leave room for ambiguity.
- **Keep it Focused:** A skill should ideally do one thing extremely well. If it's too broad, consider breaking it down into multiple skills.
- **Context is Key:** Ensure the `description` in the YAML block is accurate, as this is how the agent decides whether to load the skill.
