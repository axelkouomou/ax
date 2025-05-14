<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250413155530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE user_action DROP FOREIGN KEY FK_229E97AF162CB942
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_action DROP FOREIGN KEY FK_229E97AF93CB796C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_action DROP FOREIGN KEY FK_229E97AFA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_action
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE user_action (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, file_id INT DEFAULT NULL, folder_id INT DEFAULT NULL, action VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, action_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', details VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_229E97AF162CB942 (folder_id), INDEX IDX_229E97AF93CB796C (file_id), INDEX IDX_229E97AFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_action ADD CONSTRAINT FK_229E97AF162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_action ADD CONSTRAINT FK_229E97AF93CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_action ADD CONSTRAINT FK_229E97AFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
    }
}
