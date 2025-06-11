# 🌍 WorldManager

[![PMMP API 5.x](https://img.shields.io/badge/PocketMine--MP-API%205.x-blue?logo=pocketmine)](https://github.com/pmmp/PocketMine-MP)
[![License: MIT](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Plugin Status](https://img.shields.io/badge/status-active-brightgreen)]()
[![Made with ❤️ for PMMP](https://img.shields.io/badge/made%20for-PocketMine--MP-orange)](https://pmmp.io)

**WorldManager** is a powerful and lightweight world management plugin for PocketMine-MP servers.  
Create, delete, duplicate, rename, load, unload, teleport and fully control your worlds directly in-game — all with region support!

---

## ✨ Features

- 🔧 Create new worlds (supports custom generators)
- 🗑 Delete worlds safely
- 📦 Duplicate (clone) worlds
- ✏ Rename existing worlds
- 🚀 Teleport between worlds
- 🔄 Load & unload worlds dynamically
- 📃 List all available worlds
- 🗺 Region management system (`/wm region`)
- 🎯 Full permission system
- ⚡ Fast and optimized performance
- 🎮 In-game commands with aliases and tab completion

---

## 📥 Installation

1️⃣ Download the latest release of the plugin.  
2️⃣ Place the `.phar` file into your server's `plugins/` directory.  
3️⃣ Restart your server.

---

## ⚙ Commands

Main command: `/worldmanager`  
Alias: `/wm`

| Subcommand | Description | Usage | Aliases | Permission |
|-------------|-------------|--------|---------|-------------|
| `help` | Show help message | `/worldmanager help` | — | `worldmanager.subcommand.help` |
| `region` | Region management | `/worldmanager region <args>` | `rg` | `worldmanager.subcommand.region` |
| `delete` | Delete a world | `/worldmanager delete <world>` | — | `worldmanager.subcommand.delete` |
| `duplicate` | Duplicate a world | `/worldmanager duplicate <source> <newName>` | `clone` | `worldmanager.subcommand.duplicate` |
| `list` | List all worlds | `/worldmanager list` | `ls` | `worldmanager.subcommand.list` |
| `tp` | Teleport to world | `/worldmanager tp <world>` | `teleport` | `worldmanager.subcommand.tp` |
| `create` | Create new world | `/worldmanager create <name> <generator>` | `new` | `worldmanager.subcommand.create` |
| `load` | Load world | `/worldmanager load <name>` | — | `worldmanager.subcommand.load` |
| `unload` | Unload world | `/worldmanager unload <name>` | — | `worldmanager.subcommand.unload` |
| `rename` | Rename world | `/worldmanager rename <oldName> <newName>` | — | `worldmanager.subcommand.rename` |

---

## 🔐 Permissions

| Permission | Description | Default |
|-------------|-------------|---------|
| `worldmanager.command` | Access main command | OP |
| `worldmanager.subcommand.help` | Help command | true |
| `worldmanager.subcommand.region` | Region commands | OP |
| `worldmanager.subcommand.delete` | Delete worlds | OP |
| `worldmanager.subcommand.duplicate` | Duplicate worlds | OP |
| `worldmanager.subcommand.list` | List worlds | true |
| `worldmanager.subcommand.tp` | Teleport to worlds | OP |
| `worldmanager.subcommand.create` | Create worlds | OP |
| `worldmanager.subcommand.load` | Load worlds | OP |
| `worldmanager.subcommand.unload` | Unload worlds | OP |
| `worldmanager.subcommand.rename` | Rename worlds | OP |

---

## 🗺 Region System

Region management commands are accessible via:

/worldmanager region <args>


Alias: `/wm rg`  
*(Region subcommands can be expanded based on your plugin details)*

---

## 📦 Requirements

- PocketMine-MP: **API 5.x**
- PHP: **8.0+**

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

---

## ❤️ Support

If you enjoy using this plugin, consider giving a ⭐ star on GitHub or sharing feedback!

---

