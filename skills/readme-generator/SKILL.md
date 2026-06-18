---
name: README Generator
description: A skill to automatically generate a high-quality README.md file for a software project based on its directory structure and code.
---

# README Generator

Use this skill whenever you are asked to create, generate, or improve a project's `README.md` file.

## Workflow

1. **Analyze the Project Structure:** Review the root directory files to identify the technologies, frameworks, and purpose of the project (e.g., look for `package.json`, `requirements.txt`, `go.mod`, etc.).
2. **Determine Key Components:** Identify the main features, how to install dependencies, and how to run the project locally.
3. **Draft the README.md:** Generate the content using the standard template below.
4. **Refine and Format:** Ensure all markdown is properly formatted with syntax highlighting for code blocks.

## Standard README Template

The generated README should include at minimum:
- Project Title and brief description
- Prerequisites (software required to run)
- Installation instructions
- Usage instructions (how to run/start the app)
- Project Structure (optional, if complex)

## Rules
- Always use proper Markdown formatting with headers, lists, and code blocks.
- Do not invent installation commands; derive them from the package managers present in the project.
- Keep the language professional and concise.
