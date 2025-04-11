<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250411092445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE user_action ADD user_id INT NOT NULL, ADD file_id INT DEFAULT NULL, ADD folder_id INT DEFAULT NULL, ADD action VARCHAR(20) NOT NULL, ADD action_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', ADD details VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_action ADD CONSTRAINT FK_229E97AFA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_action ADD CONSTRAINT FK_229E97AF93CB796C FOREIGN KEY (file_id) REFERENCES file (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_action ADD CONSTRAINT FK_229E97AF162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_229E97AFA76ED395 ON user_action (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_229E97AF93CB796C ON user_action (file_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_229E97AF162CB942 ON user_action (folder_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE user_action DROP FOREIGN KEY FK_229E97AFA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_action DROP FOREIGN KEY FK_229E97AF93CB796C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_action DROP FOREIGN KEY FK_229E97AF162CB942
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_229E97AFA76ED395 ON user_action
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_229E97AF93CB796C ON user_action
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_229E97AF162CB942 ON user_action
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_action DROP user_id, DROP file_id, DROP folder_id, DROP action, DROP action_at, DROP details
        SQL);
    }
}
